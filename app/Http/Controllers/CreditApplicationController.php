<?php

namespace App\Http\Controllers;

use App\Models\CreditApplication;
use App\Models\UmkmApplication;
use App\Models\EmployeeApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;

/**
 * @mixin \Illuminate\Foundation\Auth\User
 */
class CreditApplicationController extends Controller
{
    /**
     * Menampilkan daftar aplikasi kredit (non-draft).
     * Hak akses: Admin, Direksi, Kepala Bagian Kredit, Teller (terbatas)
     */
    public function index()
    {
        $query = CreditApplication::with(['user', 'umkmApplication', 'employeeApplication'])
                                  ->where('status', '!=', 'Draft');

        if (Auth::user()->hasRole('Teller')) {
            $query->where('user_id', Auth::id());
        }

        $applications = $query->get();

        return view('applications.index', compact('applications'));
    }

    /**
     * Menampilkan daftar aplikasi kredit berstatus 'Draft'.
     * Hak akses: Teller (hanya miliknya), Kepala Bagian Kredit (semua draft), Admin (semua draft)
     */
    public function drafts()
    {
        $query = CreditApplication::with(['user', 'umkmApplication', 'employeeApplication'])
                                  ->where('status', 'Draft');

        if (Auth::user()->hasRole('Teller')) {
            // Teller hanya bisa melihat draft yang diinputnya sendiri
            $query->where('user_id', Auth::id());
        }
        // Kepala Bagian Kredit dan Admin bisa melihat semua draft

        $draftApplications = $query->get();

        return view('applications.drafts', compact('draftApplications'));
    }


    /**
     * Menampilkan form untuk membuat aplikasi kredit baru.
     * Hak akses: Teller, Kepala Bagian Kredit, Admin
     */
    public function create()
    {
        if (!Auth::user()->can('create credit application')) {
            abort(403, 'Unauthorized action.');
        }
        return view('applications.create');
    }

    /**
     * Menyimpan aplikasi kredit baru ke database.
     * Hak akses: Teller, Kepala Bagian Kredit, Admin
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create credit application')) {
            abort(403, 'Unauthorized action.');
        }

        $action = $request->input('action');
        $initialStatus = ($action === 'draft') ? 'Draft' : 'Submitted';

        // Validasi dasar yang selalu diperlukan
        $request->validate([
            'applicant_name' => 'required|string|max:255',
            'application_type' => 'required|in:UMKM/Pengusaha,Pegawai',
        ]);

        // Simpan data ke tabel credit_applications
        $creditApplication = CreditApplication::create([
            'user_id' => Auth::id(),
            'applicant_name' => $request->applicant_name,
            'application_type' => $request->application_type,
            'status' => $initialStatus,
        ]);

        // Validasi dan penyimpanan data ke tabel spesifik berdasarkan application_type
        if ($request->application_type === 'UMKM/Pengusaha') {
            $request->validate([
                'omzet_usaha' => 'required|numeric|min:0',
                'lama_usaha' => 'required|integer|min:0',
                'sektor_ekonomi' => 'required|string|max:255',
                'lokasi_usaha' => 'required|string|max:255',
                'riwayat_pinjaman' => 'required|string|max:255',
                'jenis_penggunaan_kredit' => 'required|string|max:255',
                'jenis_jaminan' => 'required|string|max:255',
                'sumber_dana_pengembalian' => 'required|string|max:255',
                'plafond_pengajuan' => 'required|numeric|min:0',
                'jangka_waktu_kredit' => 'required|integer|min:1',
            ]);

            UmkmApplication::create(array_merge(
                ['credit_application_id' => $creditApplication->id],
                $request->only([
                    'omzet_usaha', 'lama_usaha', 'sektor_ekonomi', 'lokasi_usaha',
                    'riwayat_pinjaman', 'jenis_penggunaan_kredit', 'jenis_jaminan',
                    'sumber_dana_pengembalian', 'plafond_pengajuan', 'jangka_waktu_kredit'
                ])
            ));
        } elseif ($request->application_type === 'Pegawai') {
            $request->validate([
                'usia' => 'required|integer|min:18|max:100',
                'masa_kerja' => 'required|integer|min:0',
                'golongan_jabatan' => 'required|string|max:255',
                'status_kepegawaian' => 'required|string|max:255',
                'gaji_bulanan' => 'required|numeric|min:0',
                'jumlah_tanggungan' => 'required|integer|min:0',
                'riwayat_kredit' => 'required|string|max:255',
                'jenis_penggunaan_kredit' => 'required|string|max:255',
                'jenis_jaminan' => 'required|string|max:255',
                'sumber_dana_pengembalian' => 'required|string|max:255',
                'plafond_pengajuan' => 'required|numeric|min:0',
                'jangka_waktu_kredit' => 'required|integer|min:1',
            ]);

            EmployeeApplication::create(array_merge(
                ['credit_application_id' => $creditApplication->id],
                $request->only([
                    'usia', 'masa_kerja', 'golongan_jabatan', 'status_kepegawaian',
                    'gaji_bulanan', 'jumlah_tanggungan', 'riwayat_kredit',
                    'jenis_penggunaan_kredit', 'jenis_jaminan', 'sumber_dana_pengembalian',
                    'plafond_pengajuan', 'jangka_waktu_kredit'
                ])
            ));
        }

        if ($action === 'submit') {
            $dataToPython = [
                'application_id' => $creditApplication->id,
                'application_type' => $request->application_type,
                'data' => ($request->application_type === 'UMKM/Pengusaha') ? $request->only([
                    'omzet_usaha', 'lama_usaha', 'sektor_ekonomi', 'lokasi_usaha',
                    'riwayat_pinjaman', 'jenis_penggunaan_kredit', 'jenis_jaminan',
                    'sumber_dana_pengembalian', 'plafond_pengajuan', 'jangka_waktu_kredit'
                ]) : $request->only([
                    'usia', 'masa_kerja', 'golongan_jabatan', 'status_kepegawaian',
                    'gaji_bulanan', 'jumlah_tanggungan', 'riwayat_kredit',
                    'jenis_penggunaan_kredit', 'jenis_jaminan', 'sumber_dana_pengembalian',
                    'plafond_pengajuan', 'jangka_waktu_kredit'
                ])
            ];

            try {
                // Ganti 'py' dengan jalur lengkap ke py.exe yang Anda temukan
                // Contoh: 'C:\Windows\py.exe' atau 'C:\Users\YourUsername\AppData\Local\Programs\Python\Launcher\py.exe'
                $pythonExecutablePath = 'YOUR_FULL_PATH_TO_PY.EXE'; // GANTI INI DENGAN JALUR ASLI ANDA
                $command = $pythonExecutablePath . ' ' . base_path('python_scripts/scoring.py') . ' ' . escapeshellarg(json_encode($dataToPython));
                $result = Process::run($command);

                if ($result->successful()) {
                    $pythonOutput = json_decode($result->output(), true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $creditApplication->scoring_result = $pythonOutput['score'] ?? null;
                        $creditApplication->recommendation = $pythonOutput['recommendation'] ?? null;
                        $creditApplication->status = $pythonOutput['status'] ?? 'Submitted';
                        $creditApplication->save();
                    } else {
                        Log::error('Failed to decode Python output: ' . $result->output());
                    }
                } else {
                    Log::error('Python script failed: ' . $result->errorOutput());
                }
            } catch (\Exception $e) {
                Log::error('Error executing Python script: ' . $e->getMessage());
            }
        }

        $message = ($action === 'draft') ? 'Aplikasi kredit berhasil disimpan sebagai draft!' : 'Aplikasi kredit berhasil diajukan dan sedang diproses!';
        return redirect()->route('applications.index')->with('success', $message);
    }

    /**
     * Menampilkan detail aplikasi kredit.
     * Hak akses: Admin, Direksi, Kepala Bagian Kredit (terbatas), Teller (terbatas)
     */
    public function show(CreditApplication $application)
    {
        // Logika otorisasi untuk melihat detail aplikasi
        // Admin, Direksi, Kepala Bagian Kredit bisa melihat semua.
        // Teller hanya bisa melihat miliknya sendiri.
        // Jika Teller tapi bukan miliknya, maka abort.
        if (Auth::user()->hasRole('Teller') && $application->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $application->load(['umkmApplication', 'employeeApplication']);

        $canViewScoring = Auth::user()->can('view scoring result');

        return view('applications.show', compact('application', 'canViewScoring'));
    }

    /**
     * Menampilkan form untuk mengedit aplikasi kredit.
     * Hak akses: Admin, Kepala Bagian Kredit (terbatas), Teller (terbatas pada miliknya)
     */
    public function edit(CreditApplication $application)
    {
        // Admin bisa edit semua.
        // Kepala Bagian Kredit bisa edit jika punya 'edit credit application'.
        // Teller bisa edit aplikasi yang dia input sendiri DAN punya 'edit credit application'.
        if (Auth::user()->hasRole('Admin') ||
            (Auth::user()->hasRole('Kepala Bagian Kredit') && Auth::user()->can('edit credit application')) ||
            (Auth::user()->hasRole('Teller') && Auth::user()->can('edit credit application') && $application->user_id === Auth::id())) {
            $application->load(['umkmApplication', 'employeeApplication']);
            return view('applications.edit', compact('application'));
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Memperbarui aplikasi kredit di database.
     * Hak akses: Admin, Kepala Bagian Kredit (terbatas), Teller (terbatas pada miliknya)
     */
    public function update(Request $request, CreditApplication $application)
    {
        // Admin bisa update semua.
        // Kepala Bagian Kredit bisa update jika punya 'edit credit application'.
        // Teller bisa update aplikasi yang dia input sendiri DAN punya 'edit credit application'.
        if (Auth::user()->hasRole('Admin') ||
            (Auth::user()->hasRole('Kepala Bagian Kredit') && Auth::user()->can('edit credit application')) ||
            (Auth::user()->hasRole('Teller') && Auth::user()->can('edit credit application') && $application->user_id === Auth::id())) {
            $request->validate([
                'applicant_name' => 'required|string|max:255',
                'application_type' => 'required|in:UMKM/Pengusaha,Pegawai',
            ]);

            $newStatus = $request->status ?? $application->status;

            $application->update([
                'applicant_name' => $request->applicant_name,
                'application_type' => $request->application_type,
                'status' => $newStatus,
            ]);

            if ($request->application_type === 'UMKM/Pengusaha' && $application->umkmApplication) {
                $request->validate([
                    'omzet_usaha' => 'required|numeric|min:0',
                    'lama_usaha' => 'required|integer|min:0',
                    'sektor_ekonomi' => 'required|string|max:255',
                    'lokasi_usaha' => 'required|string|max:255',
                    'riwayat_pinjaman' => 'required|string|max:255',
                    'jenis_penggunaan_kredit' => 'required|string|max:255',
                    'jenis_jaminan' => 'required|string|max:255',
                    'sumber_dana_pengembalian' => 'required|string|max:255',
                    'plafond_pengajuan' => 'required|numeric|min:0',
                    'jangka_waktu_kredit' => 'required|integer|min:1',
                ]);
                $application->umkmApplication->update($request->only([
                    'omzet_usaha', 'lama_usaha', 'sektor_ekonomi', 'lokasi_usaha',
                    'riwayat_pinjaman', 'jenis_penggunaan_kredit', 'jenis_jaminan',
                    'sumber_dana_pengembalian', 'plafond_pengajuan', 'jangka_waktu_kredit'
                ]));
            } elseif ($request->application_type === 'Pegawai' && $application->employeeApplication) {
                $request->validate([
                    'usia' => 'required|integer|min:18|max:100',
                    'masa_kerja' => 'required|integer|min:0',
                    'golongan_jabatan' => 'required|string|max:255',
                    'status_kepegawaian' => 'required|string|max:255',
                    'gaji_bulanan' => 'required|numeric|min:0',
                    'jumlah_tanggungan' => 'required|integer|min:0',
                    'riwayat_kredit' => 'required|string|max:255',
                    'jenis_penggunaan_kredit' => 'required|string|max:255',
                    'jenis_jaminan' => 'required|string|max:255',
                    'sumber_dana_pengembalian' => 'required|string|max:255',
                    'plafond_pengajuan' => 'required|numeric|min:0',
                    'jangka_waktu_kredit' => 'required|integer|min:1',
                ]);
                $application->employeeApplication->update($request->only([
                    'usia', 'masa_kerja', 'golongan_jabatan', 'status_kepegawaian',
                    'gaji_bulanan', 'jumlah_tanggungan', 'riwayat_kredit',
                    'jenis_penggunaan_kredit', 'jenis_jaminan', 'sumber_dana_pengembalian',
                    'plafond_pengajuan', 'jangka_waktu_kredit'
                ]));
            }

            if ($newStatus !== 'Draft' && ($application->isDirty() || $application->status === 'Submitted' || $application->status === 'Pending')) {
                $dataToPython = [
                    'application_id' => $application->id,
                    'application_type' => $application->application_type,
                    'data' => ($application->application_type === 'UMKM/Pengusaha') ? ($application->umkmApplication ? $application->umkmApplication->toArray() : []) : ($application->employeeApplication ? $application->employeeApplication->toArray() : [])
                ];

                try {
                    // Ganti 'py' dengan jalur lengkap ke py.exe yang Anda temukan
                    $pythonExecutablePath = 'YOUR_FULL_PATH_TO_PY.EXE'; // GANTI INI DENGAN JALUR ASLI ANDA
                    $command = $pythonExecutablePath . ' ' . base_path('python_scripts/scoring.py') . ' ' . escapeshellarg(json_encode($dataToPython));
                    $result = Process::run($command);

                    if ($result->successful()) {
                        $pythonOutput = json_decode($result->output(), true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $application->scoring_result = $pythonOutput['score'] ?? null;
                            $application->recommendation = $pythonOutput['recommendation'] ?? null;
                            $application->status = $pythonOutput['status'] ?? $application->status;
                            $application->save();
                        } else {
                            Log::error('Failed to decode Python output: ' . $result->output());
                        }
                    } else {
                        Log::error('Python script failed: ' . $result->errorOutput());
                    }
                } catch (\Exception $e) {
                    Log::error('Error executing Python script: ' . $e->getMessage());
                }
            }

            return redirect()->route('applications.index')->with('success', 'Aplikasi kredit berhasil diperbarui!');
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Menghapus aplikasi kredit.
     * Hak akses: Admin, Kepala Bagian Kredit (terbatas), Teller (terbatas pada miliknya)
     */
    public function destroy(CreditApplication $application)
    {
        // Admin bisa hapus semua.
        // Kepala Bagian Kredit bisa hapus jika punya 'delete credit application'.
        // Teller bisa hapus aplikasi yang dia input sendiri DAN punya 'delete credit application'.
        if (Auth::user()->hasRole('Admin') ||
            (Auth::user()->hasRole('Kepala Bagian Kredit') && Auth::user()->can('delete credit application')) ||
            (Auth::user()->hasRole('Teller') && Auth::user()->can('delete credit application') && $application->user_id === Auth::id())) {
            $application->delete();
            return redirect()->route('applications.index')->with('success', 'Aplikasi kredit berhasil dihapus!');
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Memperbarui status aplikasi (Approved/Rejected).
     * Hak akses: Direksi (dan Admin)
     */
    public function updateStatus(Request $request, CreditApplication $application)
    {
        // Hanya Direksi dan Admin yang bisa melakukan ini
        if (!Auth::user()->hasRole('Direksi') && !Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        $application->status = $request->status;
        $application->save();

        $message = ($request->status === 'Approved') ? 'Aplikasi berhasil disetujui!' : 'Aplikasi berhasil ditolak!';
        return redirect()->route('applications.index')->with('success', $message);
    }
}
