<?php

namespace App\Http\Controllers;

use App\Models\CreditApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        // Hanya Admin dan Direksi yang bisa mengakses controller ini
        $this->middleware('can:access full reports'); // Admin
        $this->middleware('can:access strategic reports')->only(['index']); // Direksi
    }

    /**
     * Menampilkan halaman laporan dan analisis.
     * Hak akses: Admin, Direksi
     */
    public function index()
    {
        // Contoh data untuk laporan
        // Total aplikasi
        $totalApplications = CreditApplication::count();

        // Aplikasi berdasarkan status
        $applicationsByStatus = CreditApplication::select('status', DB::raw('count(*) as total'))
                                ->groupBy('status')
                                ->get();

        // Aplikasi berdasarkan tipe
        $applicationsByType = CreditApplication::select('application_type', DB::raw('count(*) as total'))
                              ->groupBy('application_type')
                              ->get();

        // Rata-rata plafond pengajuan (UMKM)
        $avgPlafondUmkm = DB::table('umkm_applications')->avg('plafond_pengajuan');

        // Rata-rata gaji bulanan (Pegawai)
        $avgGajiPegawai = DB::table('employee_applications')->avg('gaji_bulanan');

        // Anda bisa menambahkan lebih banyak data agregat di sini sesuai kebutuhan laporan
        // Misalnya, tren pengajuan, distribusi skor, dll.

        return view('reports.index', compact(
            'totalApplications',
            'applicationsByStatus',
            'applicationsByType',
            'avgPlafondUmkm',
            'avgGajiPegawai'
        ));
    }
}
