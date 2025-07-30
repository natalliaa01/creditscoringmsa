<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Aplikasi Kredit Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-2xl text-msa-blue mb-4">Informasi Pemohon</h3>

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

                        <div class="mb-4">
                            <x-input-label for="applicant_name" :value="__('Nama Pemohon')" />
                            <x-text-input id="applicant_name" class="block mt-1 w-full" type="text" name="applicant_name" :value="old('applicant_name')" required autofocus />
                            <x-input-error :messages="$errors->get('applicant_name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="nik" :value="__('NIK')" />
                            <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" required />
                            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                            <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir')" required />
                            <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="nama_kantor_usaha" :value="__('Nama Kantor/Usaha')" />
                            <x-text-input id="nama_kantor_usaha" class="block mt-1 w-full" type="text" name="nama_kantor_usaha" :value="old('nama_kantor_usaha')" />
                            <x-input-error :messages="$errors->get('nama_kantor_usaha')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="application_type" :value="__('Tipe Aplikasi')" />
                            <select id="application_type" name="application_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Tipe Aplikasi</option>
                                <option value="UMKM/Pengusaha" {{ old('application_type') == 'UMKM/Pengusaha' ? 'selected' : '' }}>UMKM/Pengusaha</option>
                                <option value="Pegawai" {{ old('application_type') == 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
                            </select>
                            <x-input-error :messages="$errors->get('application_type')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="plafond_pengajuan" :value="__('Plafond Pengajuan (Rp)')" />
                            <x-text-input id="plafond_pengajuan" class="block mt-1 w-full" type="number" name="plafond_pengajuan" :value="old('plafond_pengajuan')" min="0" step="0.01" required />
                            <x-input-error :messages="$errors->get('plafond_pengajuan')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="jangka_waktu_kredit" :value="__('Jangka Waktu Kredit (Bulan)')" />
                            <x-text-input id="jangka_waktu_kredit" class="block mt-1 w-full" type="number" name="jangka_waktu_kredit" :value="old('jangka_waktu_kredit')" min="1" required />
                            <x-input-error :messages="$errors->get('jangka_waktu_kredit')" class="mt-2" />
                        </div>


                        <div id="umkm_form" class="hidden">
                            <h3 class="font-semibold text-xl text-msa-blue mb-4 mt-6">Data Aplikasi UMKM/Pengusaha</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <x-input-label for="omzet_usaha" :value="__('Omzet Usaha Bulanan (Rp)')" />
                                    <x-text-input id="omzet_usaha" class="block mt-1 w-full" type="number" name="omzet_usaha" :value="old('omzet_usaha')" min="0" step="0.01" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="lama_usaha" :value="__('Lama Usaha (Tahun)')" />
                                    <x-text-input id="lama_usaha" class="block mt-1 w-full" type="number" name="lama_usaha" :value="old('lama_usaha')" min="0" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="sektor_ekonomi" :value="__('Sektor Ekonomi')" />
                                    <x-text-input id="sektor_ekonomi" class="block mt-1 w-full" type="text" name="sektor_ekonomi" :value="old('sektor_ekonomi')" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="lokasi_usaha" :value="__('Lokasi Usaha')" />
                                    <x-text-input id="lokasi_usaha" class="block mt-1 w-full" type="text" name="lokasi_usaha" :value="old('lokasi_usaha')" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="riwayat_pinjaman_umkm" :value="__('Riwayat Pinjaman Sebelumnya (UMKM)')" />
                                    <select id="riwayat_pinjaman_umkm" name="riwayat_pinjaman" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Pilih</option>
                                        <option value="Ada" {{ old('riwayat_pinjaman') == 'Ada' ? 'selected' : '' }}>Ada</option>
                                        <option value="Tidak Ada" {{ old('riwayat_pinjaman') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                        <option value="Pernah Macet" {{ old('riwayat_pinjaman') == 'Pernah Macet' ? 'selected' : '' }}>Pernah Macet</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="jenis_penggunaan_kredit_umkm" :value="__('Jenis Penggunaan Kredit')" />
                                    <x-text-input id="jenis_penggunaan_kredit_umkm" class="block mt-1 w-full" type="text" name="jenis_penggunaan_kredit" :value="old('jenis_penggunaan_kredit')" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="sumber_dana_pengembalian_umkm" :value="__('Sumber Dana Pengembalian')" />
                                    <x-text-input id="sumber_dana_pengembalian_umkm" class="block mt-1 w-full" type="text" name="sumber_dana_pengembalian" :value="old('sumber_dana_pengembalian')" />
                                </div>
                            </div>
                        </div>

                        <div id="pegawai_form" class="hidden">
                            <h3 class="font-semibold text-xl text-msa-blue mb-4 mt-6">Data Aplikasi Pegawai</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <x-input-label for="usia" :value="__('Usia (Tahun)')" />
                                    <x-text-input id="usia" class="block mt-1 w-full" type="number" name="usia" :value="old('usia')" min="18" max="100" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="masa_kerja" :value="__('Masa Kerja (Tahun)')" />
                                    <x-text-input id="masa_kerja" class="block mt-1 w-full" type="number" name="masa_kerja" :value="old('masa_kerja')" min="0" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="golongan_jabatan" :value="__('Golongan/Jabatan')" />
                                    <x-text-input id="golongan_jabatan" class="block mt-1 w-full" type="text" name="golongan_jabatan" :value="old('golongan_jabatan')" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="status_kepegawaian" :value="__('Status Kepegawaian')" />
                                    <select id="status_kepegawaian" name="status_kepegawaian" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Pilih</option>
                                        <option value="Tetap" {{ old('status_kepegawaian') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                        <option value="Kontrak" {{ old('status_kepegawaian') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                        <option value="Outsource" {{ old('status_kepegawaian') == 'Outsource' ? 'selected' : '' }}>Outsource</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="gaji_bulanan" :value="__('Gaji Bulanan (Rp)')" />
                                    <x-text-input id="gaji_bulanan" class="block mt-1 w-full" type="number" name="gaji_bulanan" :value="old('gaji_bulanan')" min="0" step="0.01" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="jumlah_tanggungan" :value="__('Jumlah Tanggungan')" />
                                    <x-text-input id="jumlah_tanggungan" class="block mt-1 w-full" type="number" name="jumlah_tanggungan" :value="old('jumlah_tanggungan')" min="0" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="riwayat_kredit_pegawai" :value="__('Riwayat Kredit Sebelumnya (Pegawai)')" />
                                    <select id="riwayat_kredit_pegawai" name="riwayat_kredit" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Pilih</option>
                                        <option value="Ada" {{ old('riwayat_kredit') == 'Ada' ? 'selected' : '' }}>Ada</option>
                                        <option value="Tidak Ada" {{ old('riwayat_kredit') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                        <option value="Pernah Macet" {{ old('riwayat_kredit') == 'Pernah Macet' ? 'selected' : '' }}>Pernah Macet</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="jenis_penggunaan_kredit_pegawai" :value="__('Jenis Penggunaan Kredit')" />
                                    <x-text-input id="jenis_penggunaan_kredit_pegawai" class="block mt-1 w-full" type="text" name="jenis_penggunaan_kredit" :value="old('jenis_penggunaan_kredit')" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="sumber_dana_pengembalian_pegawai" :value="__('Sumber Dana Pengembalian')" />
                                    <x-text-input id="sumber_dana_pengembalian_pegawai" class="block mt-1 w-full" type="text" name="sumber_dana_pengembalian" :value="old('sumber_dana_pengembalian')" />
                                </div>
                            </div>
                        </div>

                        {{-- Bagian Jaminan Dinamis --}}
                        <h3 class="font-semibold text-xl text-msa-blue mb-4 mt-6">Informasi Jaminan</h3>
                        <div class="mb-4">
                            <x-input-label for="jenis_jaminan_utama" :value="__('Jenis Jaminan Utama')" />
                            <select id="jenis_jaminan_utama" name="jenis_jaminan" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih Jenis Jaminan</option>
                                <option value="Tidak Ada" {{ old('jenis_jaminan') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                <option value="Bangunan" {{ old('jenis_jaminan') == 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
                                <option value="Kendaraan Bermotor" {{ old('jenis_jaminan') == 'Kendaraan Bermotor' ? 'selected' : '' }}>Kendaraan Bermotor</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis_jaminan')" class="mt-2" />
                        </div>

                        <div id="jaminan_bangunan_fields" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <x-input-label for="luas_bangunan" :value="__('Luas Bangunan (m²)')" />
                                <x-text-input id="luas_bangunan" class="block mt-1 w-full" type="number" name="luas_bangunan" :value="old('luas_bangunan')" min="0" step="0.01" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="alamat_jaminan_bangunan" :value="__('Alamat Jaminan Bangunan')" />
                                <x-text-input id="alamat_jaminan_bangunan" class="block mt-1 w-full" type="text" name="alamat_jaminan_bangunan" :value="old('alamat_jaminan_bangunan')" />
                            </div>
                        </div>

                        <div id="jaminan_kendaraan_fields" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <x-input-label for="merk_kendaraan" :value="__('Merk Kendaraan')" />
                                <x-text-input id="merk_kendaraan" class="block mt-1 w-full" type="text" name="merk_kendaraan" :value="old('merk_kendaraan')" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="tahun_kendaraan" :value="__('Tahun Kendaraan')" />
                                <x-text-input id="tahun_kendaraan" class="block mt-1 w-full" type="number" name="tahun_kendaraan" :value="old('tahun_kendaraan')" min="1900" max="{{ date('Y') }}" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="atas_nama_kendaraan" :value="__('Atas Nama Kendaraan')" />
                                <x-text-input id="atas_nama_kendaraan" class="block mt-1 w-full" type="text" name="atas_nama_kendaraan" :value="old('atas_nama_kendaraan')" />
                            </div>
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            {{-- Tombol Ajukan Aplikasi --}}
                            <x-primary-button type="submit" name="action" value="submit">
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

            const jenisJaminanUtamaSelect = document.getElementById('jenis_jaminan_utama');
            const jaminanBangunanFields = document.getElementById('jaminan_bangunan_fields');
            const jaminanKendaraanFields = document.getElementById('jaminan_kendaraan_fields');

            // Collect all inputs within the dynamic forms for easier management
            const umkmInputs = umkmForm.querySelectorAll('input, select');
            const pegawaiInputs = pegawaiForm.querySelectorAll('input, select');
            const bangunanInputs = jaminanBangunanFields.querySelectorAll('input, select');
            const kendaraanInputs = jaminanKendaraanFields.querySelectorAll('input, select');

            // Define which fields are REQUIRED for each form type in HTML
            const umkmHtmlRequiredFields = [
                'omzet_usaha', 'lama_usaha', 'sektor_ekonomi', 'lokasi_usaha',
                'riwayat_pinjaman', 'jenis_penggunaan_kredit', 'sumber_dana_pengembalian'
            ];
            const pegawaiHtmlRequiredFields = [
                'usia', 'masa_kerja', 'golongan_jabatan', 'status_kepegawaian',
                'gaji_bulanan', 'jumlah_tanggungan', 'riwayat_kredit'
            ];

            const bangunanHtmlRequiredFields = ['luas_bangunan', 'alamat_jaminan_bangunan'];
            const kendaraanHtmlRequiredFields = ['merk_kendaraan', 'tahun_kendaraan', 'atas_nama_kendaraan'];


            function toggleRequiredAttributes(inputs, requiredFields, setRequired) {
                inputs.forEach(el => {
                    if (requiredFields.includes(el.name)) {
                        if (setRequired) {
                            el.setAttribute('required', 'required');
                        } else {
                            el.removeAttribute('required');
                        }
                    } else {
                        // For fields not in the requiredFields list for this form type, ensure they are NOT required
                        el.removeAttribute('required');
                    }
                });
            }

            // Function to disable/enable inputs to control what gets submitted
            function toggleInputEnabledState(inputs, enable) {
                inputs.forEach(el => {
                    if (enable) {
                        el.removeAttribute('disabled');
                    } else {
                        el.setAttribute('disabled', 'disabled');
                    }
                });
            }

            function toggleForms() {
                const selectedType = applicationTypeSelect.value;

                // First, disable all dynamic form fields and remove required attributes
                toggleInputEnabledState(umkmInputs, false); // Disable UMKM inputs
                toggleRequiredAttributes(umkmInputs, umkmHtmlRequiredFields, false);

                toggleInputEnabledState(pegawaiInputs, false); // Disable Pegawai inputs
                toggleRequiredAttributes(pegawaiInputs, pegawaiHtmlRequiredFields, false);


                if (selectedType === 'UMKM/Pengusaha') {
                    umkmForm.classList.remove('hidden');
                    pegawaiForm.classList.add('hidden');
                    toggleInputEnabledState(umkmInputs, true); // Enable UMKM inputs
                    toggleRequiredAttributes(umkmInputs, umkmHtmlRequiredFields, true);
                } else if (selectedType === 'Pegawai') {
                    umkmForm.classList.add('hidden');
                    pegawaiForm.classList.remove('hidden');
                    toggleInputEnabledState(pegawaiInputs, true); // Enable Pegawai inputs
                    toggleRequiredAttributes(pegawaiInputs, pegawaiHtmlRequiredFields, true);
                } else {
                    umkmForm.classList.add('hidden');
                    pegawaiForm.classList.add('hidden');
                }
            }

            function toggleJaminanFields() {
                const selectedJaminan = jenisJaminanUtamaSelect.value;
                // Disable all collateral inputs and remove required
                toggleInputEnabledState(bangunanInputs, false);
                toggleRequiredAttributes(bangunanInputs, bangunanHtmlRequiredFields, false);
                toggleInputEnabledState(kendaraanInputs, false);
                toggleRequiredAttributes(kendaraanInputs, kendaraanHtmlRequiredFields, false);

                jaminanBangunanFields.classList.add('hidden');
                jaminanKendaraanFields.classList.add('hidden');

                // Tampilkan dan set required serta enable yang relevan
                if (selectedJaminan === 'Bangunan') {
                    jaminanBangunanFields.classList.remove('hidden');
                    toggleInputEnabledState(bangunanInputs, true);
                    toggleRequiredAttributes(bangunanInputs, bangunanHtmlRequiredFields, true);
                } else if (selectedJaminan === 'Kendaraan Bermotor') {
                    jaminanKendaraanFields.classList.remove('hidden');
                    toggleInputEnabledState(kendaraanInputs, true);
                    toggleRequiredAttributes(kendaraanInputs, kendaraanHtmlRequiredFields, true);
                }
            }


            // Initial call to set form visibility and required attributes based on old input or default
            toggleForms();
            toggleJaminanFields();

            // Listen for changes
            applicationTypeSelect.addEventListener('change', toggleForms);
            jenisJaminanUtamaSelect.addEventListener('change', toggleJaminanFields);

            // Handle validation errors on page load to show correct form and re-apply required states
            const oldApplicationType = "{{ old('application_type', '') }}";
            if (oldApplicationType === 'UMKM/Pengusaha') {
                umkmForm.classList.remove('hidden');
                pegawaiForm.classList.add('hidden');
                toggleInputEnabledState(umkmInputs, true); // Enable UMKM inputs
                toggleRequiredAttributes(umkmInputs, umkmHtmlRequiredFields, true);
            } else if (oldApplicationType === 'Pegawai') {
                umkmForm.classList.add('hidden');
                pegawaiForm.classList.remove('hidden');
                toggleInputEnabledState(pegawaiInputs, true); // Enable Pegawai inputs
                toggleRequiredAttributes(pegawaiInputs, pegawaiHtmlRequiredFields, true);
            }

            const oldJenisJaminan = "{{ old('jenis_jaminan', '') }}";
            if (oldJenisJaminan === 'Bangunan') {
                jaminanBangunanFields.classList.remove('hidden');
                toggleInputEnabledState(bangunanInputs, true);
                toggleRequiredAttributes(bangunanInputs, bangunanHtmlRequiredFields, true);
            } else if (oldJenisJaminan === 'Kendaraan Bermotor') {
                jaminanKendaraanFields.classList.remove('hidden');
                toggleInputEnabledState(kendaraanInputs, true);
                toggleRequiredAttributes(kendaraanInputs, kendaraanHtmlRequiredFields, true);
            }
        });
    </script>
</x-app-layout>