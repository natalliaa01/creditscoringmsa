<x-app-layout>
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

                    {{-- Filter Periode --}}
                    <div class="mb-6 flex items-center space-x-4">
                        <label for="filter_period" class="block text-sm font-medium text-gray-700">Filter Periode:</label>
                        <select id="filter_period" onchange="window.location.href = '?period=' + this.value"
                                class="block w-auto border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="all" {{ $filterPeriod == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                            <option value="this_month" {{ $filterPeriod == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="this_year" {{ $filterPeriod == 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Total Aplikasi -->
                        <div class="bg-blue-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-blue-700">Total Kredit</p>
                            <p class="text-3xl font-bold text-blue-900">{{ $totalApplications }}</p>
                        </div>

                        <!-- Aplikasi Disetujui -->
                        <div class="bg-green-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-green-700">Aplikasi Disetujui</p>
                            <p class="text-3xl font-bold text-green-900">{{ $approvedCount }}</p>
                        </div>

                        <!-- Aplikasi Ditolak -->
                        <div class="bg-red-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-red-700">Aplikasi Ditolak</p>
                            <p class="text-3xl font-bold text-red-900">{{ $rejectedCount }}</p>
                        </div>

                        <!-- Rasio Persetujuan -->
                        <div class="bg-purple-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-purple-700">Rasio Persetujuan</p>
                            <p class="text-3xl font-bold text-purple-900">{{ number_format($approvalRate, 2) }}%</p>
                        </div>

                        <!-- Rasio Penolakan -->
                        <div class="bg-orange-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-orange-700">Rasio Penolakan</p>
                            <p class="text-3xl font-bold text-orange-900">{{ number_format($rejectionRate, 2) }}%</p>
                        </div>

                        <!-- Rata-rata Skor -->
                        <div class="bg-yellow-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-yellow-700">Rata-rata Skor Kredit</p>
                            <p class="text-3xl font-bold text-yellow-900">{{ number_format($averageScore, 2) }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Aplikasi Berdasarkan Status -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Aplikasi Berdasarkan Status</h4>
                            <ul class="list-disc list-inside">
                                @forelse ($applicationsByStatus as $status => $count)
                                    <li>{{ $status }}: <span class="font-semibold">{{ $count }}</span></li>
                                @empty
                                    <li>Tidak ada data status.</li>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Aplikasi Berdasarkan Tipe -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Aplikasi Berdasarkan Tipe</h4>
                            <ul class="list-disc list-inside">
                                @forelse ($applicationsByType as $type => $count)
                                    <li>{{ $type }}: <span class="font-semibold">{{ $count }}</span></li>
                                @empty
                                    <li>Tidak ada data tipe aplikasi.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    {{-- Bagian untuk Grafik Tren Aplikasi --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Tren Kredit per Bulan (Tahun Ini)</h4>
                        <div class="relative h-80"> {{-- Tambahkan kontainer responsif --}}
                            <canvas id="applicationsChart"></canvas>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Grafik ini akan menampilkan tren pengajuan, persetujuan, dan penolakan aplikasi per bulan.</p>
                    </div>

                    {{-- Bagian untuk Distribusi Skor --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Distribusi Skor Kredit</h4>
                        <div class="relative h-80"> {{-- Tambahkan kontainer responsif --}}
                            <canvas id="scoreDistributionChart"></canvas>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Grafik ini akan menampilkan distribusi skor kredit dalam rentang tertentu.</p>
                    </div>

                    {{-- Script untuk Chart.js --}}
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Data untuk Grafik Tren Aplikasi
                            const applicationsPerMonthData = @json($applicationsPerMonth);
                            const months = applicationsPerMonthData.map(item => {
                                const date = new Date(2000, item.month - 1, 1); // Tahun dummy, bulan -1 karena indeks
                                return date.toLocaleString('id-ID', { month: 'long' });
                            });
                            const totalApps = applicationsPerMonthData.map(item => item.total_applications);
                            const approvedApps = applicationsPerMonthData.map(item => item.approved_applications);
                            const rejectedApps = applicationsPerMonthData.map(item => item.rejected_applications);

                            const applicationsCtx = document.getElementById('applicationsChart').getContext('2d');
                            new Chart(applicationsCtx, {
                                type: 'line',
                                data: {
                                    labels: months,
                                    datasets: [
                                        {
                                            label: 'Total Aplikasi',
                                            data: totalApps,
                                            borderColor: 'rgb(75, 192, 192)',
                                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                            tension: 0.3, // Sedikit kurva
                                            fill: true
                                        },
                                        {
                                            label: 'Disetujui',
                                            data: approvedApps,
                                            borderColor: 'rgb(0, 128, 0)',
                                            backgroundColor: 'rgba(0, 128, 0, 0.2)',
                                            tension: 0.3,
                                            fill: true
                                        },
                                        {
                                            label: 'Ditolak',
                                            data: rejectedApps,
                                            borderColor: 'rgb(255, 99, 132)',
                                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                            tension: 0.3,
                                            fill: true
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false, // Penting untuk responsivitas
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                        },
                                        title: {
                                            display: false,
                                            text: 'Tren Kredit'
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                precision: 0 // Pastikan sumbu Y adalah bilangan bulat
                                            }
                                        }
                                    }
                                }
                            });

                            // Data untuk Distribusi Skor
                            const scoreDistributionData = @json($scoreDistribution);
                            const scoreLabels = Object.keys(scoreDistributionData);
                            const scoreCounts = Object.values(scoreDistributionData);

                            const scoreCtx = document.getElementById('scoreDistributionChart').getContext('2d');
                            new Chart(scoreCtx, {
                                type: 'bar',
                                data: {
                                    labels: scoreLabels,
                                    datasets: [{
                                        label: 'Jumlah Aplikasi',
                                        data: scoreCounts,
                                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false, // Penting untuk responsivitas
                                    plugins: {
                                        legend: {
                                            display: false // Tidak perlu legend untuk histogram sederhana
                                        },
                                        title: {
                                            display: false,
                                            text: 'Distribusi Skor'
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                precision: 0 // Pastikan sumbu Y adalah bilangan bulat
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>