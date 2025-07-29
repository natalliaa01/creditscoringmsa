<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Aplikasi Kredit Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pemohon</h3>

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('applications.store') }}">
                        @csrf

                        <!-- Nama Pemohon -->
                        <div class="mb-4">
                            <x-input-label for="applicant_name" :value="__('Nama Pemohon')" />
                            <x-text-input id="applicant_name" class="block mt-1 w-full" type="text" name="applicant_name" :value="old('applicant_name')" required autofocus />
                            <x-input-error :messages="$errors->get('applicant_name')" class="mt-2" />
                        </div>

                        <!-- Tipe Aplikasi -->
                        <div class="mb-4">
                            <x-input-label for="application_type" :value="__('Tipe Aplikasi')" />
                            <select id="application_type" name="application_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Tipe Aplikasi</option>
                                <option value="UMKM/Pengusaha" {{ old('application_type') == 'UMKM/Pengusaha' ? 'selected' : '' }}>UMKM/Pengusaha</option>
                                <option value="Pegawai" {{ old('application_type') == 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
                            </select>
                            <x-input-error :messages="$errors->get('application_type')" class="mt-2" />
                        </div>

                        <!-- Form UMKM/Pengusaha (akan ditampilkan secara dinamis) -->
                        <div id="umkm_form" class="hidden">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Data Aplikasi UMKM/Pengusaha</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <x-input-label for="omzet_usaha" :value="__('Omzet Usaha Bulanan (Rp)')" />
                                    <x-text-input id="omzet_usaha" class="block mt-1 w-full" type="number" name="omzet_usaha" :value="old('omzet_usaha')" min="0" step="0.01" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="lama_usaha" :value="__('Lama Usaha (Tahun)')" />
                                    <x-text-input id="lama_usaha" class="block mt-1 w-full" type="number" name="lama_usaha" :value="old('lama_usaha')" min="0" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="sektor_ekonomi" :value="__('Sektor Ekonomi')" />
                                    <x-text-input id="sektor_ekonomi" class="block mt-1 w-full" type="text" name="sektor_ekonomi" :value="old('sektor_ekonomi')" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="lokasi_usaha" :value="__('Lokasi Usaha')" />
                                    <x-text-input id="lokasi_usaha" class="block mt-1 w-full" type="text" name="lokasi_usaha" :value="old('lokasi_usaha')" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="riwayat_pinjaman_umkm" :value="__('Riwayat Pinjaman Sebelumnya (UMKM)')" />
                                    <select id="riwayat_pinjaman_umkm" name="riwayat_pinjaman" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">Pilih</option>
                                        <option value="Ada" {{ old('riwayat_pinjaman') == 'Ada' ? 'selected' : '' }}>Ada</option>
                                        <option value="Tidak Ada" {{ old('riwayat_pinjaman') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                        <option value="Pernah Macet" {{ old('riwayat_pinjaman') == 'Pernah Macet' ? 'selected' : '' }}>Pernah Macet</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="jenis_penggunaan_kredit" :value="__('Jenis Penggunaan Kredit')" />
                                    <x-text-input id="jenis_penggunaan_kredit" class="block mt-1 w-full" type="text" name="jenis_penggunaan_kredit" :value="old('jenis_penggunaan_kredit')" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="jenis_jaminan" :value="__('Jenis Jaminan')" />
                                    <x-text-input id="jenis_jaminan" class="block mt-1 w-full" type="text" name="jenis_jaminan" :value="old('jenis_jaminan')" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="sumber_dana_pengembalian" :value="__('Sumber Dana Pengembalian')" />
                                    <x-text-input id="sumber_dana_pengembalian" class="block mt-1 w-full" type="text" name="sumber_dana_pengembalian" :value="old('sumber_dana_pengembalian')" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="plafond_pengajuan" :value="__('Plafond Pengajuan (Rp)')" />
                                    <x-text-input id="plafond_pengajuan" class="block mt-1 w-full" type="number" name="plafond_pengajuan" :value="old('plafond_pengajuan')" min="0" step="0.01" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="jangka_waktu_kredit" :value="__('Jangka Waktu Kredit (Bulan)')" />
                                    <x-text-input id="jangka_waktu_kredit" class="block mt-1 w-full" type="number" name="jangka_waktu_kredit" :value="old('jangka_waktu_kredit')" min="1" required />
                                </div>
                            </div>
                        </div>

                        <!-- Form Pegawai (akan ditampilkan secara dinamis) -->
                        <div id="pegawai_form" class="hidden">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Data Aplikasi Pegawai</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <x-input-label for="usia" :value="__('Usia (Tahun)')" />
                                    <x-text-input id="usia" class="block mt-1 w-full" type="number" name="usia" :value="old('usia')" min="18" max="100" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="masa_kerja" :value="__('Masa Kerja (Tahun)')" />
                                    <x-text-input id="masa_kerja" class="block mt-1 w-full" type="number" name="masa_kerja" :value="old('masa_kerja')" min="0" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="golongan_jabatan" :value="__('Golongan/Jabatan')" />
                                    <x-text-input id="golongan_jabatan" class="block mt-1 w-full" type="text" name="golongan_jabatan" :value="old('golongan_jabatan')" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="status_kepegawaian" :value="__('Status Kepegawaian')" />
                                    <select id="status_kepegawaian" name="status_kepegawaian" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">Pilih</option>
                                        <option value="Tetap" {{ old('status_kepegawaian') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                        <option value="Kontrak" {{ old('status_kepegawaian') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                        <option value="Outsource" {{ old('status_kepegawaian') == 'Outsource' ? 'selected' : '' }}>Outsource</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="gaji_bulanan" :value="__('Gaji Bulanan (Rp)')" />
                                    <x-text-input id="gaji_bulanan" class="block mt-1 w-full" type="number" name="gaji_bulanan" :value="old('gaji_bulanan')" min="0" step="0.01" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="jumlah_tanggungan" :value="__('Jumlah Tanggungan')" />
                                    <x-text-input id="jumlah_tanggungan" class="block mt-1 w-full" type="number" name="jumlah_tanggungan" :value="old('jumlah_tanggungan')" min="0" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="riwayat_kredit_pegawai" :value="__('Riwayat Kredit Sebelumnya (Pegawai)')" />
                                    <select id="riwayat_kredit_pegawai" name="riwayat_kredit" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">Pilih</option>
                                        <option value="Ada" {{ old('riwayat_kredit') == 'Ada' ? 'selected' : '' }}>Ada</option>
                                        <option value="Tidak Ada" {{ old('riwayat_kredit') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                        <option value="Pernah Macet" {{ old('riwayat_kredit') == 'Pernah Macet' ? 'selected' : '' }}>Pernah Macet</option>
                                    </select>
                                </div>
                                {{-- Tambahkan detail pinjaman untuk Pegawai --}}
                                <div class="mb-4">
                                    <x-input-label for="jenis_penggunaan_kredit" :value="__('Jenis Penggunaan Kredit')" />
                                    <x-text-input id="jenis_penggunaan_kredit" class="block mt-1 w-full" type="text" name="jenis_penggunaan_kredit" :value="old('jenis_penggunaan_kredit')" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="jenis_jaminan" :value="__('Jenis Jaminan')" />
                                    <x-text-input id="jenis_jaminan" class="block mt-1 w-full" type="text" name="jenis_jaminan" :value="old('jenis_jaminan')" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="sumber_dana_pengembalian" :value="__('Sumber Dana Pengembalian')" />
                                    <x-text-input id="sumber_dana_pengembalian" class="block mt-1 w-full" type="text" name="sumber_dana_pengembalian" :value="old('sumber_dana_pengembalian')" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="plafond_pengajuan" :value="__('Plafond Pengajuan (Rp)')" />
                                    <x-text-input id="plafond_pengajuan" class="block mt-1 w-full" type="number" name="plafond_pengajuan" :value="old('plafond_pengajuan')" min="0" step="0.01" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="jangka_waktu_kredit" :value="__('Jangka Waktu Kredit (Bulan)')" />
                                    <x-text-input id="jangka_waktu_kredit" class="block mt-1 w-full" type="number" name="jangka_waktu_kredit" :value="old('jangka_waktu_kredit')" min="1" required />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            {{-- Tombol Ajukan Aplikasi --}}
                            <x-primary-button class="ml-3" type="submit" name="action" value="submit">
                                {{ __('Ajukan Aplikasi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const applicationTypeSelect = document.getElementById('application_type');
            const umkmForm = document.getElementById('umkm_form');
            const pegawaiForm = document.getElementById('pegawai_form');

            function toggleForms() {
                const selectedType = applicationTypeSelect.value;
                if (selectedType === 'UMKM/Pengusaha') {
                    umkmForm.classList.remove('hidden');
                    pegawaiForm.classList.add('hidden');
                    // Set required for UMKM fields
                    umkmForm.querySelectorAll('input, select').forEach(el => el.setAttribute('required', 'required'));
                    pegawaiForm.querySelectorAll('input, select').forEach(el => el.removeAttribute('required'));
                } else if (selectedType === 'Pegawai') {
                    umkmForm.classList.add('hidden');
                    pegawaiForm.classList.remove('hidden');
                    // Set required for Pegawai fields
                    pegawaiForm.querySelectorAll('input, select').forEach(el => el.setAttribute('required', 'required'));
                    umkmForm.querySelectorAll('input, select').forEach(el => el.removeAttribute('required'));
                } else {
                    umkmForm.classList.add('hidden');
                    pegawaiForm.classList.add('hidden');
                    // Remove required from all fields if no type selected
                    umkmForm.querySelectorAll('input, select').forEach(el => el.removeAttribute('required'));
                    pegawaiForm.querySelectorAll('input, select').forEach(el => el.removeAttribute('required'));
                }
            }

            // Initial call to set form visibility based on old input or default
            toggleForms();

            // Listen for changes
            applicationTypeSelect.addEventListener('change', toggleForms);

            // Handle validation errors on page load to show correct form
            const oldApplicationType = "{{ old('application_type', '') }}";
            if (oldApplicationType === 'UMKM/Pengusaha') {
                umkmForm.classList.remove('hidden');
                pegawaiForm.classList.add('hidden');
            } else if (oldApplicationType === 'Pegawai') {
                umkmForm.classList.add('hidden');
                pegawaiForm.classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
