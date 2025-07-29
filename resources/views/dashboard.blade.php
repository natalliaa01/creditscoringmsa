<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600 mb-6">Anda masuk sebagai:
                        @foreach (Auth::user()->roles as $role)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </p>

                    {{-- Konten untuk Admin --}}
                    @role('Admin')
                        <div class="mb-8">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Ringkasan Admin</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="bg-indigo-50 p-4 rounded-lg shadow-sm">
                                    <p class="text-sm text-indigo-700">Manajemen Pengguna</p>
                                    <a href="{{ route('users.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Kelola Pengguna & Peran &rarr;</a>
                                </div>
                                <div class="bg-indigo-50 p-4 rounded-lg shadow-sm">
                                    <p class="text-sm text-indigo-700">Semua Aplikasi Kredit</p>
                                    <a href="{{ route('applications.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Lihat Semua Aplikasi &rarr;</a>
                                </div>
                                <div class="bg-indigo-50 p-4 rounded-lg shadow-sm">
                                    <p class="text-sm text-indigo-700">Laporan Sistem Penuh</p>
                                    <a href="{{ route('reports.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Akses Laporan & Analisis &rarr;</a>
                                </div>
                                <div class="bg-indigo-50 p-4 rounded-lg shadow-sm">
                                    <p class="text-sm text-indigo-700">Manajemen Data Master</p>
                                    <a href="{{ route('economic-sectors.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Kelola Sektor Ekonomi &rarr;</a>
                                </div>
                                <div class="bg-indigo-50 p-4 rounded-lg shadow-sm">
                                    <p class="text-sm text-indigo-700">Aplikasi Draft</p>
                                    <a href="{{ route('applications.drafts') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Lihat Semua Draft &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endrole

                    {{-- Konten untuk Direksi --}}
                    @role('Direksi')
                        <div class="mb-8">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Ringkasan Direksi</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-green-50 p-4 rounded-lg shadow-sm">
                                    <p class="text-sm text-green-700">Tinjau Aplikasi Kredit</p>
                                    <a href="{{ route('applications.index') }}" class="text-green-600 hover:text-green-900 font-semibold">Lihat Daftar Aplikasi &rarr;</a>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg shadow-sm">
                                    <p class="text-sm text-green-700">Akses Laporan Strategis</p>
                                    <a href="{{ route('reports.index') }}" class="text-green-600 hover:text-green-900 font-semibold">Lihat Laporan & Analisis &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endrole

                    {{-- Konten untuk Kepala Bagian Kredit --}}
                    @role('Kepala Bagian Kredit')
                        <div class="mb-8">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Ringkasan Kepala Bagian Kredit</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-yellow-50 p-4 rounded-lg shadow-sm">
                                    <p class="text-sm text-yellow-700">Ajukan Aplikasi Baru</p>
                                    <a href="{{ route('applications.create') }}" class="text-yellow-600 hover:text-yellow-900 font-semibold">Mulai Pengajuan Kredit &rarr;</a>
                                </div>
                                <div class="bg-yellow-50 p-4 rounded-lg shadow-sm">
                                    <p class="text-sm text-yellow-700">Kelola Aplikasi Tim</p>
                                    <a href="{{ route('applications.index') }}" class="text-yellow-600 hover:text-yellow-900 font-semibold">Lihat & Edit Aplikasi &rarr;</a>
                                </div>
                                <div class="bg-yellow-50 p-4 rounded-lg shadow-sm">
                                    <p class="text-sm text-yellow-700">Aplikasi Draft</p>
                                    <a href="{{ route('applications.drafts') }}" class="text-yellow-600 hover:text-yellow-900 font-semibold">Lihat Aplikasi Draft &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endrole

                    {{-- Konten untuk Teller --}}
                    @role('Teller')
                        <div class="mb-8">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Ringkasan Teller</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-red-50 p-4 rounded-lg shadow-sm">
                                    <p class="text-sm text-red-700">Input Aplikasi Baru</p>
                                    <a href="{{ route('applications.create') }}" class="text-red-600 hover:text-red-900 font-semibold">Mulai Pengajuan Kredit &rarr;</a>
                                </div>
                                <div class="bg-red-50 p-4 rounded-lg shadow-sm">
                                    <p class="text-sm text-red-700">Lihat Aplikasi Saya</p>
                                    <a href="{{ route('applications.index') }}" class="text-red-600 hover:text-red-900 font-semibold">Tinjau Aplikasi yang Diajukan &rarr;</a>
                                </div>
                                <div class="bg-red-50 p-4 rounded-lg shadow-sm">
                                    <p class="text-sm text-red-700">Aplikasi Draft</p>
                                    <a href="{{ route('applications.drafts') }}" class="text-red-600 hover:text-red-900 font-semibold">Lihat Aplikasi Draft &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endrole

                    {{-- Default content if no specific role matches (should not happen with defined roles) --}}
                    @unlessrole('Admin|Direksi|Kepala Bagian Kredit|Teller')
                        <div class="p-4 bg-gray-100 border border-gray-300 rounded-md">
                            <p class="text-gray-700">Anda berhasil masuk! Silakan jelajahi fitur yang tersedia.</p>
                        </div>
                    @endunlessrole

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
