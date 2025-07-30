<?php

namespace App\Http\Controllers;

use App\Models\CreditApplication;
use App\Models\UmkmApplication;
use App\Models\EmployeeApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Validation\Rule; // Tambahkan ini untuk aturan Rule::requiredIf/nullable


/**
 * @mixin \Illuminate\Foundation\Auth\User
 */
class CreditApplicationController extends Controller
{
    /**
     * Menampilkan daftar aplikasi kredit (non-draft).
     * Hak akses: Admin, Direksi, Kepala Bagian Kredit, Teller (terbatas)
     */
    public function index(Request $request)
    {
        $query = CreditApplication::with(['user', 'umkmApplication', 'employeeApplication'])
                                 ->where('status', '!=', 'Draft');

        // Logika Search Bar
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('applicant_name', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        // Logika Filter Status
        if ($request->filled('status_filter')) {
            $statusFilter = $request->input('status_filter');
            $query->where('status', $statusFilter);
        }

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
        // --- DEBUGGING: Log semua data request yang masuk ---
        Log::info('Incoming request data for store method:', $request->all());
        // --- Akhir Debugging ---

        if (!Auth::user()->can('create credit application')) {
            abort(403, 'Unauthorized action.');
        }

        $action = $request->input('action');
        $initialStatus = 'Submitted';

        // Definisikan aturan validasi utama
        $rules = [
            'applicant_name' => 'required|string|max:255',
            'nik' => 'required|string|max:255|unique:credit_applications',
            'tanggal_lahir' => 'required|date',
            'nama_kantor_usaha' => 'nullable|string|max:255',
            'application_type' => 'required|in:UMKM/Pengusaha,Pegawai',
            'jenis_jaminan' => 'nullable|string|max:255',
            'plafond_pengajuan' => 'required|numeric|min:0',
            'jangka_waktu_kredit' => 'required|integer|min:1',
        ];

        // Aturan validasi kondisional berdasarkan application_type
        if ($request->application_type === 'UMKM/Pengusaha') {
            $rules = array_merge($rules, [
                'omzet_usaha' => 'required|numeric|min:0',
                'lama_usaha' => 'required|integer|min:0',
                'sektor_ekonomi' => 'required|string|max:255',
                'lokasi_usaha' => 'required|string|max:255',
                'riwayat_pinjaman' => 'required|string|max:255',
                'jenis_penggunaan_kredit' => 'required|string|max:255', // REQUIRED untuk UMKM
                'sumber_dana_pengembalian' => 'required|string|max:255', // REQUIRED untuk UMKM
            ]);
        } elseif ($request->application_type === 'Pegawai') {
            $rules = array_merge($rules, [
                'usia' => 'required|integer|min:18|max:100',
                'masa_kerja' => 'required|integer|min:0',
                'golongan_jabatan' => 'required|string|max:255',
                'status_kepegawaian' => 'required|string|max:255',
                'gaji_bulanan' => 'required|numeric|min:0',
                'jumlah_tanggungan' => 'required|integer|min:0',
                'riwayat_kredit' => 'required|string|max:255',
                'jenis_penggunaan_kredit' => 'nullable|string|max:255', // NULLABLE untuk Pegawai
                'sumber_dana_pengembalian' => 'nullable|string|max:255', // NULLABLE untuk Pegawai
            ]);
        }

        // Aturan validasi untuk detail jaminan dinamis (jika jenis_jaminan dipilih)
        $jenisJaminanUtama = $request->input('jenis_jaminan');
        if ($jenisJaminanUtama === 'Bangunan') {
            $rules = array_merge($rules, [
                'luas_bangunan' => 'required|numeric|min:0',
                'alamat_jaminan_bangunan' => 'required|string|max:255',
            ]);
        } elseif ($jenisJaminanUtama === 'Kendaraan Bermotor') {
            $rules = array_merge($rules, [
                'merk_kendaraan' => 'required|string|max:255',
                'tahun_kendaraan' => 'required|integer|min:1900|max:' . Carbon::now()->year,
                'atas_nama_kendaraan' => 'required|string|max:255',
            ]);
        }

        // Jalankan semua validasi
        $request->validate($rules);


        $collateralDetails = [];
        if ($jenisJaminanUtama === 'Bangunan') {
            $collateralDetails = $request->only(['luas_bangunan', 'alamat_jaminan_bangunan']);
        } elseif ($jenisJaminanUtama === 'Kendaraan Bermotor') {
            $collateralDetails = $request->only(['merk_kendaraan', 'tahun_kendaraan', 'atas_nama_kendaraan']);
        }


        $creditApplication = CreditApplication::create([
            'user_id' => Auth::id(),
            'applicant_name' => $request->applicant_name,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nama_kantor_usaha' => $request->nama_kantor_usaha,
            'application_type' => $request->application_type,
            'status' => $initialStatus,
            'jenis_jaminan' => $jenisJaminanUtama,
            'collateral_details' => !empty($collateralDetails) ? json_encode($collateralDetails) : null,
        ]);

        $inputDataForPython = [];
        $modelType = $request->application_type;

        // Mengumpulkan semua data yang relevan untuk disimpan ke tabel spesifik
        // dan dikirim ke Python. Pastikan semua field yang ada di form disertakan.
        if ($request->application_type === 'UMKM/Pengusaha') {
            $umkmData = $request->only([
                'omzet_usaha', 'lama_usaha', 'sektor_ekonomi', 'lokasi_usaha',
                'riwayat_pinjaman', 'jenis_penggunaan_kredit', 'sumber_dana_pengembalian',
                'plafond_pengajuan', 'jangka_waktu_kredit'
            ]);
            UmkmApplication::create(array_merge(
                ['credit_application_id' => $creditApplication->id],
                $umkmData
            ));
            $inputDataForPython = $umkmData;
        } elseif ($request->application_type === 'Pegawai') {
            $employeeData = $request->only([
                'usia', 'masa_kerja', 'golongan_jabatan', 'status_kepegawaian',
                'gaji_bulanan', 'jumlah_tanggungan', 'riwayat_kredit',
                'jenis_penggunaan_kredit', 'sumber_dana_pengembalian', // Ini akan diambil walau nullable
                'plafond_pengajuan', 'jangka_waktu_kredit'
            ]);
            EmployeeApplication::create(array_merge(
                ['credit_application_id' => $creditApplication->id],
                $employeeData
            ));
            $inputDataForPython = $employeeData;
        }

        // Pre-processing data untuk Python: konversi numerik dan tangani null/kosong
        foreach ($inputDataForPython as $key => $value) {
            // Jika nilai kosong (null atau string kosong dari input text)
            if ($value === null || $value === '') {
                // Untuk fitur numerik, set ke 0.0
                if (in_array($key, ['omzet_usaha', 'lama_usaha', 'gaji_bulanan', 'jumlah_tanggungan', 'usia', 'masa_kerja', 'plafond_pengajuan', 'jangka_waktu_kredit'])) {
                    $inputDataForPython[$key] = 0.0;
                } else { // Untuk fitur kategorikal atau yang tidak terdefinisi secara spesifik, set ke string kosong
                    $inputDataForPython[$key] = '';
                }
            } elseif (is_numeric($value)) {
                $inputDataForPython[$key] = (float) $value;
            }
        }

        $pythonExecutablePath = 'C:\Users\natal\AppData\Local\Programs\Python\Python311\python.exe'; // Pastikan ini jalur yang benar
        $pythonScriptPath = base_path('python_scripts/scoring.py');

        try {
            $result = Process::run([
                $pythonExecutablePath,
                $pythonScriptPath,
                json_encode($inputDataForPython),
                $modelType
            ]);

            if ($result->successful()) {
                $pythonOutput = json_decode($result->output(), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $creditApplication->scoring_result = $pythonOutput['score'] ?? null;
                    $creditApplication->recommendation = $pythonOutput['rekomendasi'] ?? null;
                    $creditApplication->save();
                    Log::info('Python scoring successful for application ' . $creditApplication->id, ['output' => $pythonOutput]);
                } else {
                    Log::error('Failed to decode Python output (JSON error): ' . json_last_error_msg(), ['raw_output' => $result->output()]);
                    return back()->withErrors(['python_error' => 'Gagal memproses hasil scoring dari Python. Format output tidak valid.']);
                }
            } else {
                Log::error('Python script failed for application ' . $creditApplication->id, ['error_output' => $result->errorOutput(), 'exit_code' => $result->exitCode()]);
                return back()->withErrors(['python_error' => 'Terjadi kesalahan saat menghitung scoring: ' . $result->errorOutput()]);
            }
        } catch (\Exception $e) {
            Log::error('Error executing Python script (PHP Exception): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withErrors(['python_error' => 'Terjadi kesalahan tak terduga saat memanggil script Python: ' . $e->getMessage()]);
        }

        $message = 'Aplikasi kredit berhasil diajukan dan sedang diproses!';
        return redirect()->route('applications.index')->with('success', $message);
    }

    /**
     * Menampilkan detail aplikasi kredit.
     * Hak akses: Admin, Direksi, Kepala Bagian Kredit (terbatas), Teller (terbatas)
     */
    public function show(CreditApplication $application)
    {
        if (Auth::user()->hasRole('Teller') && $application->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $application->load(['umkmApplication', 'employeeApplication']);

        $canViewScoring = Auth::user()->can('view scoring result');

        return view('applications.show', compact('application', 'canViewScoring'));
    }

    /**
     * Menampilkan form untuk mengedit aplikasi kredit.
     * Hak akses: Admin, Kepala Bagian Kredit (terbatas), Teller (terbatas pada miliknya), Direksi (jika diberi izin)
     */
    public function edit(CreditApplication $application)
    {
        if (Auth::user()->hasRole('Admin') ||
            (Auth::user()->hasRole('Kepala Bagian Kredit') && Auth::user()->can('edit credit application')) ||
            (Auth::user()->hasRole('Teller') && Auth::user()->can('edit credit application') && $application->user_id === Auth::id()) ||
            (Auth::user()->hasRole('Direksi') && Auth::user()->can('edit credit application'))) {
            $application->load(['umkmApplication', 'employeeApplication']);
            return view('applications.edit', compact('application'));
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Memperbarui aplikasi kredit di database.
     * Hak akses: Admin, Kepala Bagian Kredit (terbatas), Teller (terbatas pada miliknya), Direksi (jika diberi izin)
     */
    public function update(Request $request, CreditApplication $application)
    {
        // --- DEBUGGING: Log semua data request yang masuk ---
        Log::info('Incoming request data for update method (Application ID: ' . $application->id . '):', $request->all());
        // --- Akhir Debugging ---

        if (Auth::user()->hasRole('Admin') ||
            (Auth::user()->hasRole('Kepala Bagian Kredit') && Auth::user()->can('edit credit application')) ||
            (Auth::user()->hasRole('Teller') && Auth::user()->can('edit credit application') && $application->user_id === Auth::id()) ||
            (Auth::user()->hasRole('Direksi') && Auth::user()->can('edit credit application'))) {

            $rules = [
                'applicant_name' => 'required|string|max:255',
                'nik' => 'required|string|max:255|unique:credit_applications,nik,' . $application->id,
                'tanggal_lahir' => 'required|date',
                'nama_kantor_usaha' => 'nullable|string|max:255',
                'application_type' => 'required|in:UMKM/Pengusaha,Pegawai',
                'jenis_jaminan' => 'nullable|string|max:255',
                'plafond_pengajuan' => 'required|numeric|min:0',
                'jangka_waktu_kredit' => 'required|integer|min:1',
            ];

            if ($request->application_type === 'UMKM/Pengusaha') {
                $rules = array_merge($rules, [
                    'omzet_usaha' => 'required|numeric|min:0',
                    'lama_usaha' => 'required|integer|min:0',
                    'sektor_ekonomi' => 'required|string|max:255',
                    'lokasi_usaha' => 'required|string|max:255',
                    'riwayat_pinjaman' => 'required|string|max:255',
                    'jenis_penggunaan_kredit' => 'required|string|max:255',
                    'sumber_dana_pengembalian' => 'required|string|max:255',
                ]);
            } elseif ($request->application_type === 'Pegawai') {
                $rules = array_merge($rules, [
                    'usia' => 'required|integer|min:18|max:100',
                    'masa_kerja' => 'required|integer|min:0',
                    'golongan_jabatan' => 'required|string|max:255',
                    'status_kepegawaian' => 'required|string|max:255',
                    'gaji_bulanan' => 'required|numeric|min:0',
                    'jumlah_tanggungan' => 'required|integer|min:0',
                    'riwayat_kredit' => 'required|string|max:255',
                    'jenis_penggunaan_kredit' => 'nullable|string|max:255',
                    'sumber_dana_pengembalian' => 'nullable|string|max:255',
                ]);
            }

            $jenisJaminanUtama = $request->input('jenis_jaminan');
            if ($jenisJaminanUtama === 'Bangunan') {
                $rules = array_merge($rules, [
                    'luas_bangunan' => 'required|numeric|min:0',
                    'alamat_jaminan_bangunan' => 'required|string|max:255',
                ]);
            } elseif ($jenisJaminanUtama === 'Kendaraan Bermotor') {
                $rules = array_merge($rules, [
                    'merk_kendaraan' => 'required|string|max:255',
                    'tahun_kendaraan' => 'required|integer|min:1900|max:' . Carbon::now()->year,
                    'atas_nama_kendaraan' => 'required|string|max:255',
                ]);
            }
            // Jalankan semua validasi
            $request->validate($rules);


            $collateralDetails = [];
            if ($jenisJaminanUtama === 'Bangunan') {
                $collateralDetails = $request->only(['luas_bangunan', 'alamat_jaminan_bangunan']);
            } elseif ($jenisJaminanUtama === 'Kendaraan Bermotor') {
                $collateralDetails = $request->only(['merk_kendaraan', 'tahun_kendaraan', 'atas_nama_kendaraan']);
            }

            $newStatus = $request->status ?? $application->status;

            $application->update([
                'applicant_name' => $request->applicant_name,
                'nik' => $request->nik,
                'tanggal_lahir' => $request->tanggal_lahir,
                'nama_kantor_usaha' => $request->nama_kantor_usaha,
                'application_type' => $request->application_type,
                'status' => $newStatus,
                'jenis_jaminan' => $jenisJaminanUtama,
                'collateral_details' => !empty($collateralDetails) ? json_encode($collateralDetails) : null,
            ]);

            $inputDataForPython = [];
            $modelType = $request->application_type;

            if ($request->application_type === 'UMKM/Pengusaha') {
                $umkmData = $request->only([
                    'omzet_usaha', 'lama_usaha', 'sektor_ekonomi', 'lokasi_usaha',
                    'riwayat_pinjaman', 'jenis_penggunaan_kredit', 'sumber_dana_pengembalian',
                    'plafond_pengajuan', 'jangka_waktu_kredit'
                ]);
                $application->umkmApplication->update($umkmData);
                $inputDataForPython = $umkmData;
            } elseif ($request->application_type === 'Pegawai') {
                $employeeData = $request->only([
                    'usia', 'masa_kerja', 'golongan_jabatan', 'status_kepegawaian',
                    'gaji_bulanan', 'jumlah_tanggungan', 'riwayat_kredit',
                    'jenis_penggunaan_kredit', 'sumber_dana_pengembalian',
                    'plafond_pengajuan', 'jangka_waktu_kredit'
                ]);
                $application->employeeApplication->update($employeeData);
                $inputDataForPython = $employeeData;
            }

            foreach ($inputDataForPython as $key => $value) {
                if ($value === null || $value === '') {
                    if (in_array($key, ['omzet_usaha', 'lama_usaha', 'gaji_bulanan', 'jumlah_tanggungan', 'usia', 'masa_kerja', 'plafond_pengajuan', 'jangka_waktu_kredit'])) {
                        $inputDataForPython[$key] = 0.0;
                    } else {
                        $inputDataForPython[$key] = '';
                    }
                } elseif (is_numeric($value)) {
                    $inputDataForPython[$key] = (float) $value;
                }
            }

            $pythonExecutablePath = 'C:\Users\natal\AppData\Local\Programs\Python\Python311\python.exe';
            $pythonScriptPath = base_path('python_scripts/scoring.py');

            if ($newStatus !== 'Draft' && ($application->isDirty() || $application->status === 'Submitted' || $application->status === 'Pending')) {
                try {
                    $result = Process::run([
                        $pythonExecutablePath,
                        $pythonScriptPath,
                        json_encode($inputDataForPython),
                        $modelType
                    ]);

                    if ($result->successful()) {
                        $pythonOutput = json_decode($result->output(), true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $application->scoring_result = $pythonOutput['score'] ?? null;
                            $application->recommendation = $pythonOutput['rekomendasi'] ?? null;
                            $application->save();
                            Log::info('Python scoring successful for updated application ' . $application->id, ['output' => $pythonOutput]);
                        } else {
                            Log::error('Failed to decode Python output (JSON error) for update: ' . json_last_error_msg(), ['raw_output' => $result->output()]);
                            return back()->withErrors(['python_error' => 'Gagal memproses hasil scoring dari Python. Format output tidak valid.']);
                        }
                    } else {
                        Log::error('Python script failed for updated application ' . $application->id, ['error_output' => $result->errorOutput(), 'exit_code' => $result->exitCode()]);
                        return back()->withErrors(['python_error' => 'Terjadi kesalahan saat menghitung scoring: ' . $result->errorOutput()]);
                    }
                } catch (\Exception $e) {
                    Log::error('Error executing Python script (PHP Exception): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                    return back()->withErrors(['python_error' => 'Terjadi kesalahan tak terduga saat memanggil script Python: ' . $e->getMessage()]);
                }
            }

            return redirect()->route('applications.index')->with('success', 'Aplikasi kredit berhasil diperbarui!');
        }

        abort(403, 'Unauthorized action.');
    }

    /**
     * Menghapus aplikasi kredit.
     * Hak akses: Admin, Kepala Bagian Kredit (terbatas), Teller (terbatas pada miliknya), Direksi (jika diberi izin)
     */
    public function destroy(CreditApplication $application)
    {
        if (Auth::user()->hasRole('Admin') ||
            (Auth::user()->hasRole('Kepala Bagian Kredit') && Auth::user()->can('delete credit application')) ||
            (Auth::user()->hasRole('Teller') && Auth::user()->can('delete credit application') && $application->user_id === Auth::id()) ||
            (Auth::user()->hasRole('Direksi') && Auth::user()->can('delete credit application'))) {
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