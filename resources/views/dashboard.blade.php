<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100"> {{-- Latar belakang halaman menjadi abu-abu --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-2xl text-msa-blue mb-4">Selamat Datang, {{ Auth::user()->name }}!</h3> {{-- Menggunakan custom class text-msa-blue --}}
                    <p class="text-msa-blue-700 mb-6">Anda masuk sebagai:
                        @foreach (Auth::user()->roles as $role)
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-msa-blue-200 text-msa-blue-900"> {{-- Menggunakan custom class --}}
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </p>

                    {{-- Konten untuk Admin --}}
                    @role('Admin')
                        <div class="mb-8">
                            <h4 class="text-xl font-semibold text-msa-blue-700 mb-4">Ringkasan Admin</h4> {{-- Menggunakan custom class --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="bg-msa-blue-100 p-4 rounded-lg shadow-md border border-msa-blue-200"> {{-- Menggunakan custom class --}}
                                    <p class="text-sm text-msa-blue-700">Manajemen Pengguna</p>
                                    <a href="{{ route('users.index') }}" class="text-msa-blue-700 hover:text-msa-blue-darker font-semibold text-lg">Kelola Pengguna & Peran &rarr;</a> {{-- Menggunakan custom class --}}
                                </div>
                                <div class="bg-msa-blue-100 p-4 rounded-lg shadow-md border border-msa-blue-200">
                                    <p class="text-sm text-msa-blue-700">Semua Aplikasi Kredit</p>
                                    <a href="{{ route('applications.index') }}" class="text-msa-blue-700 hover:text-msa-blue-darker font-semibold text-lg">Lihat Semua Aplikasi &rarr;</a>
                                </div>
                                <div class="bg-msa-blue-100 p-4 rounded-lg shadow-md border border-msa-blue-200">
                                    <p class="text-sm text-msa-blue-700">Laporan Sistem Penuh</p>
                                    <a href="{{ route('reports.index') }}" class="text-msa-blue-700 hover:text-msa-blue-darker font-semibold text-lg">Akses Laporan & Analisis &rarr;</a>
                                </div>
                                <div class="bg-msa-blue-100 p-4 rounded-lg shadow-md border border-msa-blue-200">
                                    <p class="text-sm text-msa-blue-700">Manajemen Data Master</p>
                                    <a href="{{ route('economic-sectors.index') }}" class="text-msa-blue-700 hover:text-msa-blue-darker font-semibold text-lg">Kelola Sektor Ekonomi &rarr;</a>
                                </div>
                                <div class="bg-msa-blue-100 p-4 rounded-lg shadow-md border border-msa-blue-200">
                                    <p class="text-sm text-msa-blue-700">Aplikasi Draft</p>
                                    <a href="{{ route('applications.drafts') }}" class="text-msa-blue-700 hover:text-msa-blue-darker font-semibold text-lg">Lihat Semua Draft &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endrole

                    {{-- Konten untuk Direksi --}}
                    @role('Direksi')
                        <div class="mb-8">
                            <h4 class="text-xl font-semibold text-msa-blue-700 mb-4">Ringkasan Direksi</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-msa-blue-100 p-4 rounded-lg shadow-md border border-msa-blue-200">
                                    <p class="text-sm text-msa-blue-700">Tinjau Aplikasi Kredit</p>
                                    <a href="{{ route('applications.index') }}" class="text-msa-blue-700 hover:text-msa-blue-darker font-semibold text-lg">Lihat Daftar Aplikasi &rarr;</a>
                                </div>
                                <div class="bg-msa-blue-100 p-4 rounded-lg shadow-md border border-msa-blue-200">
                                    <p class="text-sm text-msa-blue-700">Akses Laporan Strategis</p>
                                    <a href="{{ route('reports.index') }}" class="text-msa-blue-700 hover:text-msa-blue-darker font-semibold text-lg">Lihat Laporan & Analisis &rarr;</a>
                                </div>
                                <div class="bg-msa-blue-100 p-4 rounded-lg shadow-md border border-msa-blue-200">
                                    <p class="text-sm text-msa-blue-700">Aplikasi Draft</p>
                                    <a href="{{ route('applications.drafts') }}" class="text-msa-blue-700 hover:text-msa-blue-darker font-semibold text-lg">Lihat Semua Draft &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endrole

                    {{-- Konten untuk Kepala Bagian Kredit --}}
                    @role('Kepala Bagian Kredit')
                        <div class="mb-8">
                            <h4 class="text-xl font-semibold text-msa-blue-700 mb-4">Ringkasan Kepala Bagian Kredit</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-msa-blue-100 p-4 rounded-lg shadow-md border border-msa-blue-200">
                                    <p class="text-sm text-msa-blue-700">Ajukan Aplikasi Baru</p>
                                    <a href="{{ route('applications.create') }}" class="text-msa-blue-700 hover:text-msa-blue-darker font-semibold text-lg">Mulai Pengajuan Kredit &rarr;</a>
                                </div>
                                <div class="bg-msa-blue-100 p-4 rounded-lg shadow-md border border-msa-blue-200">
                                    <p class="text-sm text-msa-blue-700">Kelola Aplikasi Tim</p>
                                    <a href="{{ route('applications.index') }}" class="text-msa-blue-700 hover:text-msa-blue-darker font-semibold text-lg">Lihat & Edit Aplikasi &rarr;</a>
                                </div>
                                <div class="bg-msa-blue-100 p-4 rounded-lg shadow-md border border-msa-blue-200">
                                    <p class="text-sm text-msa-blue-700">Aplikasi Draft</p>
                                    <a href="{{ route('applications.drafts') }}" class="text-msa-blue-700 hover:text-msa-blue-darker font-semibold text-lg">Lihat Aplikasi Draft &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endrole

                    {{-- Konten untuk Teller --}}
                    @role('Teller')
                        <div class="mb-8">
                            <h4 class="text-xl font-semibold text-msa-blue-700 mb-4">Ringkasan Teller</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-msa-blue-100 p-4 rounded-lg shadow-md border border-msa-blue-200">
                                    <p class="text-sm text-msa-blue-700">Input Aplikasi Baru</p>
                                    <a href="{{ route('applications.create') }}" class="text-msa-blue-700 hover:text-msa-blue-darker font-semibold text-lg">Mulai Pengajuan Kredit &rarr;</a>
                                </div>
                                <div class="bg-msa-blue-100 p-4 rounded-lg shadow-md border border-msa-blue-200">
                                    <p class="text-sm text-msa-blue-700">Lihat Aplikasi Saya</p>
                                    <a href="{{ route('applications.index') }}" class="text-msa-blue-700 hover:text-msa-blue-darker font-semibold text-lg">Tinjau Aplikasi yang Diajukan &rarr;</a>
                                </div>
                                <div class="bg-msa-blue-100 p-4 rounded-lg shadow-md border border-msa-blue-200">
                                    <p class="text-sm text-msa-blue-700">Aplikasi Draft</p>
                                    <a href="{{ route('applications.drafts') }}" class="text-msa-blue-700 hover:text-msa-blue-darker font-semibold text-lg">Lihat Aplikasi Draft &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endrole

                    {{-- Default content if no specific role matches (should not happen with defined roles) --}}
                    @unlessrole('Admin|Direksi|Kepala Bagian Kredit|Teller')
                        <div class="p-4 bg-msa-blue-100 border border-msa-blue-200 rounded-md text-msa-blue-800">
                            <p>Anda berhasil masuk! Silakan jelajahi fitur yang tersedia.</p>
                        </div>
                    @endunlessrole

                    {{-- Bagian Berita Penting / Pembaruan --}}
                    <div class="mt-10">
                        <h4 class="text-xl font-semibold text-msa-blue-700 mb-4">Berita Penting & Pembaruan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                                <h5 class="font-semibold text-lg text-gray-800 mb-2">Pembaruan Kebijakan Kredit UMKM Terbaru</h5>
                                <p class="text-gray-600 text-sm">Efektif mulai 1 Agustus 2025, ada perubahan pada kriteria penilaian omzet usaha untuk aplikasi UMKM. Harap tinjau panduan terbaru di bagian dokumentasi sistem.</p>
                                <p class="text-msa-blue-500 text-xs mt-2">29 Juli 2025</p>
                            </div>
                            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                                <h5 class="font-semibold text-lg text-gray-800 mb-2">Jadwal Maintenance Sistem</h5>
                                <p class="text-gray-600 text-sm">Sistem akan mengalami maintenance terjadwal pada tanggal 5 Agustus 2025 pukul 22.00 - 23.00 WIB. Mohon selesaikan pekerjaan Anda sebelum waktu tersebut.</p>
                                <p class="text-msa-blue-500 text-xs mt-2">28 Juli 2025</p>
                            </div>
                            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                                <h5 class="font-semibold text-lg text-gray-800 mb-2">Tips Meningkatkan Akurasi Scoring</h5>
                                <p class="text-gray-600 text-sm">Pastikan semua data input diisi dengan lengkap dan akurat, terutama riwayat pinjaman dan sumber dana pengembalian, untuk hasil scoring yang optimal.</p>
                                <p class="text-msa-blue-500 text-xs mt-2">27 Juli 2025</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
