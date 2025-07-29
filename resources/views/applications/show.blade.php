<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Aplikasi Kredit') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-2xl text-msa-blue mb-4">Informasi Aplikasi Kredit #{{ $application->id }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-600">Nama Pemohon:</p>
                            <p class="font-semibold text-gray-900">{{ $application->applicant_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">NIK:</p>
                            <p class="font-semibold text-gray-900">{{ $application->nik }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Lahir:</p>
                            <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($application->tanggal_lahir)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nama Kantor/Usaha:</p>
                            <p class="font-semibold text-gray-900">{{ $application->nama_kantor_usaha ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tipe Aplikasi:</p>
                            <p class="font-semibold text-gray-900">{{ $application->application_type }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status:</p>
                            <p class="font-semibold text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{
                                    $application->status === 'Approved' ? 'bg-green-100 text-green-800' :
                                    ($application->status === 'Rejected' ? 'bg-red-100 text-red-800' :
                                    ($application->status === 'Draft' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800'))
                                }}">
                                    {{ $application->status }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Diajukan Oleh:</p>
                            <p class="font-semibold text-gray-900">{{ $application->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Pengajuan:</p>
                            <p class="font-semibold text-gray-900">{{ $application->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    @if ($application->application_type === 'UMKM/Pengusaha' && $application->umkmApplication)
                        <h4 class="font-semibold text-xl text-msa-blue mb-4 mt-6">Data UMKM/Pengusaha</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><p class="text-sm text-gray-600">Omzet Usaha Bulanan:</p><p class="font-semibold text-gray-900">Rp {{ number_format($application->umkmApplication->omzet_usaha, 2, ',', '.') }}</p></div>
                            <div><p class="text-sm text-gray-600">Lama Usaha:</p><p class="font-semibold text-gray-900">{{ $application->umkmApplication->lama_usaha }} Tahun</p></div>
                            <div><p class="text-sm text-gray-600">Sektor Ekonomi:</p><p class="font-semibold text-gray-900">{{ $application->umkmApplication->sektor_ekonomi }}</p></div>
                            <div><p class="text-sm text-gray-600">Lokasi Usaha:</p><p class="font-semibold text-gray-900">{{ $application->umkmApplication->lokasi_usaha }}</p></div>
                            <div><p class="text-sm text-gray-600">Riwayat Pinjaman Sebelumnya:</p><p class="font-semibold text-gray-900">{{ $application->umkmApplication->riwayat_pinjaman }}</p></div>
                            <div><p class="text-sm text-gray-600">Jenis Penggunaan Kredit:</p><p class="font-semibold text-gray-900">{{ $application->umkmApplication->jenis_penggunaan_kredit }}</p></div>
                            <div><p class="text-sm text-gray-600">Sumber Dana Pengembalian:</p><p class="font-semibold text-gray-900">{{ $application->umkmApplication->sumber_dana_pengembalian }}</p></div>
                            <div><p class="text-sm text-gray-600">Plafond Pengajuan:</p><p class="font-semibold text-gray-900">Rp {{ number_format($application->umkmApplication->plafond_pengajuan, 2, ',', '.') }}</p></div>
                            <div><p class="text-sm text-gray-600">Jangka Waktu Kredit:</p><p class="font-semibold text-gray-900">{{ $application->umkmApplication->jangka_waktu_kredit }} Bulan</p></div>
                        </div>
                    @elseif ($application->application_type === 'Pegawai' && $application->employeeApplication)
                        <h4 class="font-semibold text-xl text-msa-blue mb-4 mt-6">Data Pegawai</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><p class="text-sm text-gray-600">Usia:</p><p class="font-semibold text-gray-900">{{ $application->employeeApplication->usia }} Tahun</p></div>
                            <div><p class="text-sm text-gray-600">Masa Kerja:</p><p class="font-semibold text-gray-900">{{ $application->employeeApplication->masa_kerja }} Tahun</p></div>
                            <div><p class="text-sm text-gray-600">Golongan/Jabatan:</p><p class="font-semibold text-gray-900">{{ $application->employeeApplication->golongan_jabatan }}</p></div>
                            <div><p class="text-sm text-gray-600">Status Kepegawaian:</p><p class="font-semibold text-gray-900">{{ $application->employeeApplication->status_kepegawaian }}</p></div>
                            <div><p class="text-sm text-gray-600">Gaji Bulanan:</p><p class="font-semibold text-gray-900">Rp {{ number_format($application->employeeApplication->gaji_bulanan, 2, ',', '.') }}</p></div>
                            <div><p class="text-sm text-gray-600">Jumlah Tanggungan:</p><p class="font-semibold text-gray-900">{{ $application->employeeApplication->jumlah_tanggungan }} Orang</p></div>
                            <div><p class="text-sm text-gray-600">Riwayat Kredit Sebelumnya:</p><p class="font-semibold text-gray-900">{{ $application->employeeApplication->riwayat_kredit }}</p></div>
                            {{-- Tampilkan detail pinjaman untuk Pegawai --}}
                            <div><p class="text-sm text-gray-600">Jenis Penggunaan Kredit:</p><p class="font-semibold text-gray-900">{{ $application->employeeApplication->jenis_penggunaan_kredit }}</p></div>
                            <div><p class="text-sm text-gray-600">Jenis Jaminan:</p><p class="font-semibold text-gray-900">{{ $application->employeeApplication->jenis_jaminan }}</p></div>
                            <div><p class="text-sm text-gray-600">Sumber Dana Pengembalian:</p><p class="font-semibold text-gray-900">{{ $application->employeeApplication->sumber_dana_pengembalian }}</p></div>
                            <div><p class="text-sm text-gray-600">Plafond Pengajuan:</p><p class="font-semibold text-gray-900">Rp {{ number_format($application->employeeApplication->plafond_pengajuan, 2, ',', '.') }}</p></div>
                            <div><p class="text-sm text-gray-600">Jangka Waktu Kredit:</p><p class="font-semibold text-gray-900">{{ $application->employeeApplication->jangka_waktu_kredit }} Bulan</p></div>
                        </div>
                    @endif

                    {{-- Informasi Jaminan Dinamis --}}
                    @if ($application->jenis_jaminan)
                        <h4 class="font-semibold text-xl text-msa-blue mb-4 mt-6">Informasi Jaminan ({{ $application->jenis_jaminan }})</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if ($application->jenis_jaminan === 'Bangunan' && $application->collateral_details)
                                <div><p class="text-sm text-gray-600">Luas Bangunan:</p><p class="font-semibold text-gray-900">{{ $application->collateral_details['luas_bangunan'] ?? '-' }} m²</p></div>
                                <div><p class="text-sm text-gray-600">Alamat Jaminan:</p><p class="font-semibold text-gray-900">{{ $application->collateral_details['alamat_jaminan_bangunan'] ?? '-' }}</p></div>
                            @elseif ($application->jenis_jaminan === 'Kendaraan Bermotor' && $application->collateral_details)
                                <div><p class="text-sm text-gray-600">Merk Kendaraan:</p><p class="font-semibold text-gray-900">{{ $application->collateral_details['merk_kendaraan'] ?? '-' }}</p></div>
                                <div><p class="text-sm text-gray-600">Tahun Kendaraan:</p><p class="font-semibold text-gray-900">{{ $application->collateral_details['tahun_kendaraan'] ?? '-' }}</p></div>
                                <div><p class="text-sm text-gray-600">Atas Nama:</p><p class="font-semibold text-gray-900">{{ $application->collateral_details['atas_nama_kendaraan'] ?? '-' }}</p></div>
                            @else
                                <div><p class="text-sm text-gray-600">Jenis Jaminan:</p><p class="font-semibold text-gray-900">{{ $application->jenis_jaminan }}</p></div>
                                @if ($application->jenis_jaminan !== 'Tidak Ada')
                                    <div><p class="text-sm text-gray-600">Detail Jaminan:</p><p class="font-semibold text-gray-900">Tidak ada detail spesifik yang tersimpan.</p></div>
                                @endif
                            @endif
                        </div>
                    @else
                        <h4 class="font-semibold text-xl text-msa-blue mb-4 mt-6">Informasi Jaminan</h4>
                        <p class="text-gray-600">Tidak ada informasi jaminan yang dicatat.</p>
                    @endif


                    @if ($canViewScoring && ($application->scoring_result || $application->recommendation))
                        <h4 class="font-semibold text-xl text-msa-blue mb-4 mt-6">Hasil Scoring & Rekomendasi</h4>
                        <div class="border border-gray-200 rounded-md p-4 bg-gray-50">
                            @if ($application->scoring_result)
                                <p class="text-sm text-gray-600">Skor Kredit:</p>
                                <p class="font-semibold text-lg text-gray-900 mb-2">{{ $application->scoring_result['score'] ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">Status Rekomendasi:</p>
                                <p class="font-semibold text-lg text-gray-900 mb-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{
                                        ($application->recommendation['status'] ?? '') === 'Layak' ? 'bg-green-100 text-green-800' :
                                        (($application->recommendation['status'] ?? '') === 'Tidak Layak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')
                                    }}">
                                        {{ $application->recommendation['status'] ?? 'N/A' }}
                                    </span>
                                </p>
                            @endif
                            @if ($application->recommendation && ($application->recommendation['details'] ?? false))
                                <p class="text-sm text-gray-600 mt-2">Detail Rekomendasi:</p>
                                <ul class="list-disc list-inside text-gray-900">
                                    @foreach ($application->recommendation['details'] as $detail)
                                        <li>{{ $detail }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @elseif ($canViewScoring && (!$application->scoring_result && !$application->recommendation))
                        <div class="mt-6 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-md">
                            <p>Hasil scoring belum tersedia untuk aplikasi ini.</p>
                        </div>
                    @elseif (!$canViewScoring)
                        <div class="mt-6 p-4 bg-gray-100 border border-gray-400 text-gray-700 rounded-md">
                            <p>Anda tidak memiliki izin untuk melihat hasil scoring dan rekomendasi.</p>
                        </div>
                    @endif

                    {{-- Tombol Persetujuan/Penolakan untuk Direksi --}}
                    @role('Direksi')
                        @if ($application->status === 'Submitted' || $application->status === 'Pending')
                            <div class="mt-6 flex justify-end">
                                <button type="button" id="approveButton" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Setujui Aplikasi') }}
                                </button>

                                <button type="button" id="rejectButton" class="inline-flex items-center ml-3 px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Tolak Aplikasi') }}
                                </button>
                            </div>
                        @endif
                    @endrole


                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('applications.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Kembali ke Daftar Aplikasi') }}
                        </a>
                        @can('edit credit application')
                            {{-- Tombol Edit hanya muncul jika status bukan Approved/Rejected --}}
                            @if ($application->status !== 'Approved' && $application->status !== 'Rejected')
                                <a href="{{ route('applications.edit', $application->id) }}" class="ml-3 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Edit Aplikasi') }}
                                </a>
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom Confirmation Modal --}}
    <div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle"></h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="modalMessage"></p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmAction" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        OK
                    </button>
                    <button id="cancelAction" class="mt-3 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const approveButton = document.getElementById('approveButton');
            const rejectButton = document.getElementById('rejectButton');
            const confirmationModal = document.getElementById('confirmationModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');
            const confirmAction = document.getElementById('confirmAction');
            const cancelAction = document.getElementById('cancelAction');

            let currentForm = null;

            if (approveButton) {
                approveButton.addEventListener('click', function() {
                    modalTitle.textContent = 'Konfirmasi Persetujuan Aplikasi';
                    modalMessage.textContent = 'Apakah Anda yakin ingin MENYETUJUI aplikasi ini?';
                    confirmationModal.classList.remove('hidden');
                    currentForm = this.closest('form') || createTemporaryForm('Approved'); // Dapatkan form atau buat sementara
                });
            }

            if (rejectButton) {
                rejectButton.addEventListener('click', function() {
                    modalTitle.textContent = 'Konfirmasi Penolakan Aplikasi';
                    modalMessage.textContent = 'Apakah Anda yakin ingin MENOLAK aplikasi ini?';
                    confirmationModal.classList.remove('hidden');
                    currentForm = this.closest('form') || createTemporaryForm('Rejected'); // Dapatkan form atau buat sementara
                });
            }

            confirmAction.addEventListener('click', function() {
                confirmationModal.classList.add('hidden');
                if (currentForm) {
                    currentForm.submit();
                }
            });

            cancelAction.addEventListener('click', function() {
                confirmationModal.classList.add('hidden');
                currentForm = null; // Reset form
            });

            // Fungsi untuk membuat form sementara jika tombol tidak berada di dalam form langsung
            function createTemporaryForm(status) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('applications.update-status', $application->id) }}';
                form.style.display = 'none'; // Sembunyikan form

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);

                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = status;
                form.appendChild(statusInput);

                document.body.appendChild(form); // Tambahkan form ke body
                return form;
            }
        });
    </script>
</x-app-layout>
