x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan & Analisis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Ringkasan Laporan Kredit</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Total Aplikasi -->
                        <div class="bg-blue-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-blue-700">Total Aplikasi Kredit</p>
                            <p class="text-3xl font-bold text-blue-900">{{ $totalApplications }}</p>
                        </div>

                        <!-- Rata-rata Plafond UMKM -->
                        <div class="bg-green-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-green-700">Rata-rata Plafond Pengajuan (UMKM)</p>
                            <p class="text-xl font-bold text-green-900">Rp {{ number_format($avgPlafondUmkm, 2, ',', '.') }}</p>
                        </div>

                        <!-- Rata-rata Gaji Bulanan Pegawai -->
                        <div class="bg-purple-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-purple-700">Rata-rata Gaji Bulanan (Pegawai)</p>
                            <p class="text-xl font-bold text-purple-900">Rp {{ number_format($avgGajiPegawai, 2, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Aplikasi Berdasarkan Status -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Aplikasi Berdasarkan Status</h4>
                            <ul class="list-disc list-inside">
                                @foreach ($applicationsByStatus as $status)
                                    <li>{{ $status->status }}: <span class="font-semibold">{{ $status->total }}</span></li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Aplikasi Berdasarkan Tipe -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Aplikasi Berdasarkan Tipe</h4>
                            <ul class="list-disc list-inside">
                                @foreach ($applicationsByType as $type)
                                    <li>{{ $type->application_type }}: <span class="font-semibold">{{ $type->total }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- Anda bisa menambahkan grafik di sini menggunakan Chart.js atau library lainnya --}}
                    <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-md">
                        <p>Bagian ini dapat diperluas dengan visualisasi data yang lebih canggih (misalnya, grafik batang, pie chart) menggunakan library JavaScript seperti Chart.js atau D3.js.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
