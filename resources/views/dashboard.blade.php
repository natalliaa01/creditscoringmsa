<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        /* Base styles for dashboard elements */
        .dashboard-container {
            background-color: #f3f4f6; /* Latar belakang halaman yang lebih lembut */
        }

        .dashboard-main-card {
            border-radius: 20px; /* Sudut lebih membulat untuk kesan modern */
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08); /* Bayangan lebih dalam */
            transition: all 0.4s ease-in-out; /* Transisi lebih halus */
            overflow: hidden;
            background-color: #ffffff;
            border: none; /* Hapus border */
        }

        .dashboard-main-card:hover {
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15); /* Bayangan lebih dramatis saat hover */
            transform: translateY(-5px); /* Efek naik ringan */
        }

        .welcome-section {
            padding: 3.5rem; /* Padding lebih besar */
            background: linear-gradient(135deg, #e0eafc, #cfdef3); /* Gradient biru muda */
            border-bottom: 1px solid #c8d8e8;
            color: #1a365d;
            position: relative;
            z-index: 1;
        }
        .welcome-section h3 {
            color: #1a365d;
            font-weight: 700; /* Lebih tebal */
            font-size: 2.25rem; /* Ukuran lebih besar */
            text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
        }
        .welcome-section p {
            color: #2c5282;
            font-size: 1.1rem; /* Sedikit lebih besar */
        }
        .welcome-section .role-badge {
            padding: 0.4rem 0.8rem; /* Padding badge peran */
            font-size: 0.85rem; /* Ukuran font badge */
            border-radius: 9999px; /* Bentuk pil */
            background-color: #4F80FF; /* Warna biru utama */
            color: white;
            box-shadow: 0 2px 5px rgba(79, 128, 255, 0.3);
            transition: all 0.3s ease;
        }
        .welcome-section .role-badge:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(79, 128, 255, 0.4);
        }

        .summary-card-grid-container {
            padding: 3rem 3.5rem 3.5rem 3.5rem; /* Padding lebih besar */
            background-color: #ffffff;
        }

        .summary-card {
            border-radius: 16px; /* Sudut lebih membulat */
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08); /* Bayangan lebih jelas */
            transition: all 0.3s ease-in-out;
            border: none; /* Hapus border */
            padding: 2rem; /* Padding lebih besar di dalam kartu */
            background-color: #f8faff; /* Latar belakang kartu sangat terang */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            overflow: hidden;
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px; /* Garis atas biru */
            background-color: #4F80FF;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }

        .summary-card:hover {
            transform: translateY(-8px); /* Efek naik lebih dramatis */
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15); /* Bayangan lebih kuat saat hover */
            background-color: #eef2ff; /* Sedikit lebih gelap saat hover */
        }

        .summary-card .card-icon {
            font-size: 3.5rem; /* Ukuran ikon jauh lebih besar */
            color: #2b6cb0; /* Warna ikon biru */
            margin-bottom: 1.5rem; /* Jarak bawah ikon */
            opacity: 0.8;
        }

        .summary-card p.text-sm {
            color: #4a5568;
            margin-bottom: 0.75rem; /* Jarak bawah teks deskripsi */
            font-size: 1rem; /* Ukuran font lebih besar */
            font-weight: 500;
        }

        .summary-card a {
            color: #2b6cb0;
            font-weight: 700; /* Lebih tebal */
            font-size: 1.1rem; /* Ukuran font lebih besar */
            transition: color 0.2s ease-in-out;
            display: flex;
            align-items: center;
            margin-top: 1rem; /* Jarak atas dari teks deskripsi */
        }
        .summary-card a:hover {
            color: #1c4b7b;
            text-decoration: underline; /* Garis bawah saat hover */
        }
        .summary-card a svg,
        .summary-card a i {
            margin-left: 0.75rem; /* Jarak panah lebih jauh */
            font-size: 1em; /* Ukuran panah sesuai teks */
            transition: margin-left 0.2s ease-in-out;
        }
        .summary-card a:hover svg,
        .summary-card a:hover i {
            margin-left: 1rem; /* Panah bergerak sedikit saat hover */
        }

        .news-updates-section {
            padding: 3rem 3.5rem 3.5rem 3.5rem; /* Padding lebih besar */
            background-color: #ffffff;
            border-top: 1px solid #f0f0f0; /* Border atas untuk pemisah */
        }
        .news-updates-section h4 {
            font-weight: 700; /* Lebih tebal */
            font-size: 1.75rem; /* Ukuran lebih besar */
            color: #2d3748;
            margin-bottom: 1.5rem; /* Jarak bawah judul */
        }

        .news-update-card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
            border: 1px solid #e0e0e0;
            padding: 1.5rem;
            background-color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .news-update-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .news-update-card h5 {
            color: #2d3748;
            font-weight: 600;
            font-size: 1.1rem; /* Ukuran judul berita */
            margin-bottom: 0.5rem;
        }
        .news-update-card p {
            color: #718096;
            font-size: 0.9rem; /* Ukuran teks berita */
            line-height: 1.6;
        }
        .news-update-card p.text-msa-blue-500 {
            color: #4F80FF !important;
            font-size: 0.75rem; /* Ukuran tanggal berita */
            margin-top: 0.75rem;
            font-weight: 500;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .welcome-section {
                padding: 2rem;
            }
            .welcome-section h3 {
                font-size: 1.75rem;
            }
            .welcome-section p {
                font-size: 1rem;
            }
            .summary-card-grid-container {
                padding: 1.5rem 2rem 2rem 2rem;
            }
            .summary-card {
                padding: 1.25rem;
            }
            .summary-card .card-icon {
                font-size: 3rem;
                margin-bottom: 1rem;
            }
            .summary-card p.text-sm {
                font-size: 0.9rem;
            }
            .summary-card a {
                font-size: 1rem;
            }
            .news-updates-section {
                padding: 1.5rem 2rem 2rem 2rem;
            }
            .news-updates-section h4 {
                font-size: 1.5rem;
            }
            .news-update-card {
                padding: 1.25rem;
            }
            .news-update-card h5 {
                font-size: 1rem;
            }
        }
    </style>

    <div class="py-12 bg-gray-100 dashboard-container">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dashboard-main-card">
                <div class="p-6 welcome-section">
                    <h3 class="font-semibold text-2xl mb-4">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="mb-6">Anda masuk sebagai:
                        @foreach (Auth::user()->roles as $role)
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold role-badge">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </p>
                </div>

                {{-- Konten untuk Admin --}}
                @role('Admin')
                    <div class="mb-8 summary-card-grid-container">
                        <h4 class="text-xl font-semibold text-msa-blue-700 mb-4">Ringkasan Admin</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"> {{-- Gap lebih besar --}}
                            <div class="summary-card">
                                <i class="fa-solid fa-users card-icon"></i>
                                <p class="text-sm">Manajemen Pengguna</p>
                                <a href="{{ route('users.index') }}">Kelola Pengguna & Peran <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                            <div class="summary-card">
                                <i class="fa-solid fa-credit-card card-icon"></i>
                                <p class="text-sm">Kredit</p>
                                <a href="{{ route('applications.index') }}">Lihat Semua Aplikasi <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                            <div class="summary-card">
                                <i class="fa-solid fa-chart-line card-icon"></i>
                                <p class="text-sm">Laporan Sistem Penuh</p>
                                <a href="{{ route('reports.index') }}">Akses Laporan & Analisis <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                            <div class="summary-card">
                                <i class="fa-solid fa-database card-icon"></i>
                                <p class="text-sm">Manajemen Data Master</p>
                                <a href="{{ route('economic-sectors.index') }}">Kelola Sektor Ekonomi <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endrole

                {{-- Konten untuk Direksi --}}
                @role('Direksi')
                    <div class="mb-8 summary-card-grid-container">
                        <h4 class="text-xl font-semibold text-msa-blue-700 mb-4">Ringkasan Direksi</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="summary-card">
                                <i class="fa-solid fa-magnifying-glass-dollar card-icon"></i>
                                <p class="text-sm">Tinjau Kredit</p>
                                <a href="{{ route('applications.index') }}">Lihat Daftar Aplikasi <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                            <div class="summary-card">
                                <i class="fa-solid fa-chart-pie card-icon"></i>
                                <p class="text-sm">Akses Laporan Strategis</p>
                                <a href="{{ route('reports.index') }}">Lihat Laporan & Analisis <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endrole

                {{-- Konten untuk Kepala Bagian Kredit --}}
                @role('Kepala Bagian Kredit')
                    <div class="mb-8 summary-card-grid-container">
                        <h4 class="text-xl font-semibold text-msa-blue-700 mb-4">Ringkasan Kepala Bagian Kredit</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="summary-card">
                                <i class="fa-solid fa-file-circle-plus card-icon"></i>
                                <p class="text-sm">Ajukan Kredit</p>
                                <a href="{{ route('applications.create') }}">Mulai Pengajuan Kredit <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                            <div class="summary-card">
                                <i class="fa-solid fa-folder-open card-icon"></i>
                                <p class="text-sm">Kelola Aplikasi Tim</p>
                                <a href="{{ route('applications.index') }}">Lihat & Edit Aplikasi <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endrole

                {{-- Konten untuk Teller --}}
                @role('Teller')
                    <div class="mb-8 summary-card-grid-container">
                        <h4 class="text-xl font-semibold text-msa-blue-700 mb-4">Ringkasan Teller</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="summary-card">
                                <i class="fa-solid fa-file-pen card-icon"></i>
                                <p class="text-sm">Input Aplikasi Baru</p>
                                <a href="{{ route('applications.create') }}">Mulai Pengajuan Kredit <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                            <div class="summary-card">
                                <i class="fa-solid fa-eye card-icon"></i>
                                <p class="text-sm">Lihat Aplikasi Saya</p>
                                <a href="{{ route('applications.index') }}">Tinjau Aplikasi yang Diajukan <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endrole

                {{-- Default content if no specific role matches (should not happen with defined roles) --}}
                @unlessrole('Admin|Direksi|Kepala Bagian Kredit|Teller')
                    <div class="summary-card-grid-container">
                        <div class="p-4 bg-msa-blue-100 border border-msa-blue-200 rounded-md text-msa-blue-800 summary-card">
                            <i class="fa-solid fa-circle-info card-icon"></i>
                            <p>Anda berhasil masuk! Silakan jelajahi fitur yang tersedia.</p>
                        </div>
                    </div>
                @endunlessrole

                {{-- Bagian Berita Penting / Pembaruan --}}
                <div class="mt-10 news-updates-section">
                    <h4 class="text-xl font-semibold text-msa-blue-700 mb-4">Berita Penting & Pembaruan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="news-update-card">
                            <h5 class="font-semibold text-lg text-gray-800 mb-2">Pembaruan Kebijakan Kredit UMKM Terbaru</h5>
                            <p class="text-gray-600 text-sm">Efektif mulai 1 Agustus 2025, ada perubahan pada kriteria penilaian omzet usaha untuk aplikasi UMKM. Harap tinjau panduan terbaru di bagian dokumentasi sistem.</p>
                            <p class="text-msa-blue-500 text-xs mt-2">29 Juli 2025</p>
                        </div>
                        <div class="news-update-card">
                            <h5 class="font-semibold text-lg text-gray-800 mb-2">Jadwal Maintenance Sistem</h5>
                            <p class="text-gray-600 text-sm">Sistem akan mengalami maintenance terjadwal pada tanggal 5 Agustus 2025 pukul 22.00 - 23.00 WIB. Mohon selesaikan pekerjaan Anda sebelum waktu tersebut.</p>
                            <p class="text-msa-blue-500 text-xs mt-2">28 Juli 2025</p>
                        </div>
                        <div class="news-update-card">
                            <h5 class="font-semibold text-lg text-gray-800 mb-2">Tips Meningkatkan Akurasi Scoring</h5>
                            <p class="text-gray-600 text-sm">Pastikan semua data input diisi dengan lengkap dan akurat, terutama riwayat pinjaman dan sumber dana pengembalian, untuk hasil scoring yang optimal.</p>
                            <p class="text-msa-blue-500 text-xs mt-2">27 Juli 2025</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
