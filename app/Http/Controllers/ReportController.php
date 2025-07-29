<?php

namespace App\Http\Controllers;

use App\Models\CreditApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Import Carbon for date manipulation

/**
 * @mixin \Illuminate\Foundation\Auth\User
 */
class ReportController extends Controller
{
    public function __construct()
    {
        // Hanya Admin dan Direksi yang bisa mengakses controller ini
        $this->middleware('can:access full reports')->only(['index']);
        $this->middleware('can:access strategic reports')->only(['index']);
    }

    /**
     * Menampilkan halaman laporan dan analisis.
     * Hak akses: Admin, Direksi
     */
    public function index(Request $request)
    {
        // Filter berdasarkan periode (contoh: bulan ini, tahun ini, semua)
        $filterPeriod = $request->input('period', 'all'); // Default 'all'

        $query = CreditApplication::query();

        if ($filterPeriod === 'this_month') {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
        } elseif ($filterPeriod === 'this_year') {
            $query->whereYear('created_at', Carbon::now()->year);
        }
        // 'all' tidak memerlukan filter tambahan

        $applications = $query->get();

        // Total aplikasi
        $totalApplications = $applications->count();

        // Aplikasi berdasarkan status
        $applicationsByStatus = $applications->groupBy('status')->map->count();

        // Aplikasi berdasarkan tipe
        $applicationsByType = $applications->groupBy('application_type')->map->count();

        // Rasio Persetujuan/Penolakan
        $approvedCount = $applicationsByStatus->get('Approved', 0);
        $rejectedCount = $applicationsByStatus->get('Rejected', 0);
        $totalDecided = $approvedCount + $rejectedCount;

        $approvalRate = ($totalDecided > 0) ? ($approvedCount / $totalDecided) * 100 : 0;
        $rejectionRate = ($totalDecided > 0) ? ($rejectedCount / $totalDecided) * 100 : 0;

        // Rata-rata skor (hanya untuk aplikasi yang sudah discoring)
        $scoredApplications = $applications->filter(function ($app) {
            return !is_null($app->scoring_result);
        });
        $averageScore = $scoredApplications->avg(function ($app) {
            return $app->scoring_result['score'] ?? 0;
        });

        // Data untuk grafik (contoh: tren aplikasi per bulan)
        $applicationsPerMonth = CreditApplication::select(
                                    DB::raw('MONTH(created_at) as month'),
                                    DB::raw('COUNT(*) as total_applications'),
                                    DB::raw('SUM(CASE WHEN status = "Approved" THEN 1 ELSE 0 END) as approved_applications'),
                                    DB::raw('SUM(CASE WHEN status = "Rejected" THEN 1 ELSE 0 END) as rejected_applications')
                                )
                                ->whereYear('created_at', Carbon::now()->year) // Hanya tahun ini untuk tren
                                ->groupBy('month')
                                ->orderBy('month')
                                ->get();

        // Data untuk distribusi skor (histogram sederhana)
        // Mengumpulkan semua skor yang ada
        $allScores = $scoredApplications->pluck('scoring_result.score')->filter()->toArray();
        $scoreDistribution = [];
        if (!empty($allScores)) {
            // Contoh binning: 0-20, 21-40, ..., 81-100
            $bins = [0, 20, 40, 60, 80, 100];
            foreach ($bins as $i => $lowerBound) {
                if ($i + 1 < count($bins)) {
                    $upperBound = $bins[$i+1];
                    $count = collect($allScores)->filter(function($score) use ($lowerBound, $upperBound) {
                        return $score > $lowerBound && $score <= $upperBound;
                    })->count();
                    $scoreDistribution[($lowerBound + 1) . '-' . $upperBound] = $count;
                }
            }
        }


        return view('reports.index', compact(
            'totalApplications',
            'applicationsByStatus',
            'applicationsByType',
            'approvedCount',
            'rejectedCount',
            'approvalRate',
            'rejectionRate',
            'averageScore',
            'applicationsPerMonth',
            'scoreDistribution',
            'filterPeriod' // Kirim kembali filter yang dipilih ke view
        ));
    }
}
