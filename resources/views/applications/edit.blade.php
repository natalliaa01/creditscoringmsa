<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kredit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Kredit #{{ $application->id }}</h3>

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('applications.update', $application->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nama Pemohon -->
                        <div class="mb-4">
                            <x-input-label for="applicant_name" :value="__('Nama Pemohon')" />
                            <x-text-input id="applicant_name" class="block mt-1 w-full" type="text" name="applicant_name" :value="old('applicant_name', $application->applicant_name)" required autofocus />
                            <x-input-error :messages="$errors->get('applicant_name')" class="mt-2" />
                        </div>

                        <!-- Tipe Aplikasi (Tidak dapat diubah setelah dibuat) -->
                        <div class="mb-4">
                            <x-input-label for="application_type" :value="__('Tipe Aplikasi')" />
                            <x-text-input id="application_type" class="block mt-1 w-full bg-gray-100" type="text" name="application_type" :value="$application->application_type" readonly />
                            <p class="text-sm text-gray-500 mt-1">Tipe aplikasi tidak dapat diubah setelah dibuat.</p>
                        </div>

                        <!-- Status Aplikasi (Bisa diubah oleh Admin/Kepala Bagian Kredit) -->
                        @can('edit credit application') {{-- Admin dan Kepala Bagian Kredit --}}
                            <div class="mb-4">
                                <x-input-label for="status" :value="__('Status Aplikasi')" />
                                <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="Pending" {{ old('status', $application->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Approved" {{ old('status', $application->status) == 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Rejected" {{ old('status', $application->status) == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        @endcan


                        <!-- Form UMKM/Pengusaha -->
                        @if ($application->application_type === 'UMKM/Pengusaha' && $application->umkmApplication)
                            <div id="umkm_form">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Data Aplikasi UMKM/Pengusaha</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="mb-4">
                                        <x-input-label for="omzet_usaha" :value="__('Omzet Usaha Bulanan (Rp)')" />
                                        <x-text-input id="omzet_usaha" class="block mt-1 w-full" type="number" name="omzet_usaha" :value="old('omzet_usaha', $application->umkmApplication->omzet_usaha)" min="0" step="0.01" required />
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="lama_usaha" :value="__('Lama Usaha (Tahun)')" />
                                        <x-text-input id="lama_usaha" class="block mt-1 w-full" type="number" name="lama_usaha" :value="old('lama_usaha', $application->umkmApplication->lama_usaha)" min="0" required />
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="sektor_ekonomi" :value="__('Sektor Ekonomi')" />
                                        <x-text-input id="sektor_ekonomi" class="block mt-1 w-full" type="text" name="sektor_ekonomi" :value="old('sektor_ekonomi', $application->umkmApplication->sektor_ekonomi)" required />
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="lokasi_usaha" :value="__('Lokasi Usaha')" />
                                        <x-text-input id="lokasi_usaha" class="block mt-1 w-full" type="text" name="lokasi_usaha" :value="old('lokasi_usaha', $application->umkmApplication->lokasi_usaha)" required />
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="riwayat_pinjaman_umkm" :value="__('Riwayat Pinjaman Sebelumnya (UMKM)')" />
                                        <select id="riwayat_pinjaman_umkm" name="riwayat_pinjaman" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            <option value="">Pilih</option>
                                            <option value="Ada" {{ old('riwayat_pinjaman', $application->umkmApplication->riwayat_pinjaman) == 'Ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak Ada" {{ old('riwayat_pinjaman', $application->umkmApplication->riwayat_pinjaman) == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="jenis_penggunaan_kredit" :value="__('Jenis Penggunaan Kredit')" />
                                        <x-text-input id="jenis_penggunaan_kredit" class="block mt-1 w-full" type="text" name="jenis_penggunaan_kredit" :value="old('jenis_penggunaan_kredit', $application->umkmApplication->jenis_penggunaan_kredit)" required />
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="jenis_jaminan" :value="__('Jenis Jaminan')" />
                                        <x-text-input id="jenis_jaminan" class="block mt-1 w-full" type="text" name="jenis_jaminan" :value="old('jenis_jaminan', $application->umkmApplication->jenis_jaminan)" required />
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="sumber_dana_pengembalian" :value="__('Sumber Dana Pengembalian')" />
                                        <x-text-input id="sumber_dana_pengembalian" class="block mt-1 w-full" type="text" name="sumber_dana_pengembalian" :value="old('sumber_dana_pengembalian', $application->umkmApplication->sumber_dana_pengembalian)" required />
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="plafond_pengajuan" :value="__('Plafond Pengajuan (Rp)')" />
                                        <x-text-input id="plafond_pengajuan" class="block mt-1 w-full" type="number" name="plafond_pengajuan" :value="old('plafond_pengajuan', $application->umkmApplication->plafond_pengajuan)" min="0" step="0.01" required />
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="jangka_waktu_kredit" :value="__('Jangka Waktu Kredit (Bulan)')" />
                                        <x-text-input id="jangka_waktu_kredit" class="block mt-1 w-full" type="number" name="jangka_waktu_kredit" :value="old('jangka_waktu_kredit', $application->umkmApplication->jangka_waktu_kredit)" min="1" required />
                                    </div>
                                </div>
                            </div>
                        @elseif ($application->application_type === 'Pegawai' && $application->employeeApplication)
                            <div id="pegawai_form">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Data Aplikasi Pegawai</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="mb-4">
                                        <x-input-label for="usia" :value="__('Usia (Tahun)')" />
                                        <x-text-input id="usia" class="block mt-1 w-full" type="number" name="usia" :value="old('usia', $application->employeeApplication->usia)" min="18" max="100" required />
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="masa_kerja" :value="__('Masa Kerja (Tahun)')" />
                                        <x-text-input id="masa_kerja" class="block mt-1 w-full" type="number" name="masa_kerja" :value="old('masa_kerja', $application->employeeApplication->masa_kerja)" min="0" required />
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="golongan_jabatan" :value="__('Golongan/Jabatan')" />
                                        <x-text-input id="golongan_jabatan" class="block mt-1 w-full" type="text" name="golongan_jabatan" :value="old('golongan_jabatan', $application->employeeApplication->golongan_jabatan)" required />
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="status_kepegawaian" :value="__('Status Kepegawaian')" />
                                        <select id="status_kepegawaian" name="status_kepegawaian" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            <option value="">Pilih</option>
                                            <option value="Tetap" {{ old('status_kepegawaian', $application->employeeApplication->status_kepegawaian) == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                            <option value="Kontrak" {{ old('status_kepegawaian', $application->employeeApplication->status_kepegawaian) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                            <option value="Lainnya" {{ old('status_kepegawaian', $application->employeeApplication->status_kepegawaian) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="gaji_bulanan" :value="__('Gaji Bulanan (Rp)')" />
                                        <x-text-input id="gaji_bulanan" class="block mt-1 w-full" type="number" name="gaji_bulanan" :value="old('gaji_bulanan', $application->employeeApplication->gaji_bulanan)" min="0" step="0.01" required />
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="jumlah_tanggungan" :value="__('Jumlah Tanggungan')" />
                                        <x-text-input id="jumlah_tanggungan" class="block mt-1 w-full" type="number" name="jumlah_tanggungan" :value="old('jumlah_tanggungan', $application->employeeApplication->jumlah_tanggungan)" min="0" required />
                                    </div>
                                    <div class="mb-4">
                                        <x-input-label for="riwayat_kredit_pegawai" :value="__('Riwayat Kredit Sebelumnya (Pegawai)')" />
                                        <select id="riwayat_kredit_pegawai" name="riwayat_kredit" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                            <option value="">Pilih</option>
                                            <option value="Ada" {{ old('riwayat_kredit', $application->employeeApplication->riwayat_kredit) == 'Ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak Ada" {{ old('riwayat_kredit', $application->employeeApplication->riwayat_kredit) == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('applications.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button class="ml-3">
                                {{ __('Perbarui Aplikasi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
