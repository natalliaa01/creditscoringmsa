<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        /* Base styles for dashboard elements */
        .dashboard-container {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .dashboard-main-card {
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .dashboard-main-card:hover {
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .welcome-section {
            padding: 4rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .welcome-section h3 {
            color: white;
            font-weight: 800;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .welcome-section p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            position: relative;
            z-index: 2;
        }

        .welcome-section .role-badge {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
            border-radius: 50px;
            background: linear-gradient(145deg, #ffffff 0%, #f1f5f9 100%);
            color: #4F80FF;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 600;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .welcome-section .role-badge:hover {
            transform: scale(1.05) translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
        }

        .summary-card-grid-container {
            padding: 4rem;
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        }

        .summary-card-grid-container h4 {
            font-weight: 800;
            font-size: 1.8rem;
            color: #2d3748;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .summary-card-grid-container h4::before {
            content: '';
            width: 4px;
            height: 2rem;
            background: linear-gradient(135deg, #4F80FF 0%, #764ba2 100%);
            border-radius: 2px;
        }

        .summary-card {
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            padding: 2.5rem;
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            overflow: hidden;
            min-height: 200px;
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, #4F80FF 0%, #667eea 50%, #764ba2 100%);
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .summary-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(79, 128, 255, 0.05) 0%, transparent 70%);
            transition: all 0.4s ease;
            opacity: 0;
        }

        .summary-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            background: linear-gradient(145deg, #ffffff 0%, #f1f5f9 100%);
        }

        .summary-card:hover::after {
            opacity: 1;
        }

        .summary-card .card-icon {
            font-size: 4rem !important;
            background: linear-gradient(135deg, #4F80FF 0%, #667eea 50%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem !important;
            display: block !important;
            transition: all 0.3s ease;
            filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.1));
        }

        .summary-card:hover .card-icon {
            transform: scale(1.1) rotate(5deg);
            filter: drop-shadow(4px 4px 8px rgba(0,0,0,0.2));
        }

        .summary-card p.text-sm {
            color: #4a5568;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            font-weight: 500;
            line-height: 1.6;
        }

        .summary-card a {
            color: #4F80FF;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            margin-top: auto;
            padding: 0.5rem 0;
            border-radius: 8px;
            text-decoration: none;
        }

        .summary-card a:hover {
            color: #2d3748;
            transform: translateX(5px);
        }

        .summary-card a i {
            margin-left: 0.75rem;
            font-size: 1em;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .summary-card a:hover i {
            margin-left: 1rem;
            transform: scale(1.2);
        }

        .news-updates-section {
            padding: 4rem;
            background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .news-updates-section h4 {
            font-weight: 800;
            font-size: 1.8rem;
            color: #2d3748;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .news-updates-section h4::before {
            content: '📢';
            font-size: 1.5rem;
        }

        .news-update-card {
            border-radius: 16px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.8);
            padding: 2rem;
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            position: relative;
            overflow: hidden;
        }

        .news-update-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #4F80FF 0%, #764ba2 100%);
        }

        .news-update-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
            background: linear-gradient(145deg, #ffffff 0%, #f1f5f9 100%);
        }

        .news-update-card h5 {
            color: #2d3748;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .news-update-card h5::before {
            content: '💡';
            font-size: 1rem;
        }

        .news-update-card p {
            color: #718096;
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 0.5rem;
        }

        .news-update-card p.text-msa-blue-500 {
            color: #4F80FF !important;
            font-size: 0.85rem;
            margin-top: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .news-update-card p.text-msa-blue-500::before {
            content: '📅';
            font-size: 0.8rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .welcome-section {
                padding: 2.5rem 2rem;
            }
            .welcome-section h3 {
                font-size: 2rem;
            }
            .welcome-section p {
                font-size: 1.1rem;
            }
            .summary-card-grid-container {
                padding: 2rem;
            }
            .summary-card {
                padding: 2rem;
                min-height: 180px;
            }
            .summary-card .card-icon {
                font-size: 3.5rem !important;
                margin-bottom: 1rem !important;
            }
            .summary-card p.text-sm {
                font-size: 1rem;
            }
            .summary-card a {
                font-size: 1rem;
            }
            .news-updates-section {
                padding: 2rem;
            }
            .news-updates-section h4 {
                font-size: 1.6rem;
            }
            .news-update-card {
                padding: 1.5rem;
            }
            .news-update-card h5 {
                font-size: 1.1rem;
            }
        }

        /* Additional icon enhancements */
        .fa-users::before { content: '👥'; font-family: 'Apple Color Emoji', 'Segoe UI Emoji'; }
        .fa-credit-card::before { content: '💳'; font-family: 'Apple Color Emoji', 'Segoe UI Emoji'; }
        .fa-chart-line::before { content: '📈'; font-family: 'Apple Color Emoji', 'Segoe UI Emoji'; }
        .fa-database::before { content: '🗄️'; font-family: 'Apple Color Emoji', 'Segoe UI Emoji'; }
        .fa-magnifying-glass-dollar::before { content: '🔍💰'; font-family: 'Apple Color Emoji', 'Segoe UI Emoji'; }
        .fa-chart-pie::before { content: '📊'; font-family: 'Apple Color Emoji', 'Segoe UI Emoji'; }
        .fa-money-bill-transfer::before { content: '💸'; font-family: 'Apple Color Emoji', 'Segoe UI Emoji'; }
        .fa-folder-open::before { content: '📂'; font-family: 'Apple Color Emoji', 'Segoe UI Emoji'; }
        .fa-file-pen::before { content: '📝'; font-family: 'Apple Color Emoji', 'Segoe UI Emoji'; }
        .fa-eye::before { content: '👁️'; font-family: 'Apple Color Emoji', 'Segoe UI Emoji'; }
        .fa-circle-info::before { content: 'ℹ️'; font-family: 'Apple Color Emoji', 'Segoe UI Emoji'; }
        .fa-arrow-right::before { content: '→'; font-family: 'Apple Color Emoji', 'Segoe UI Emoji'; }
    </style>

    <div class="py-12 dashboard-container">
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
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="summary-card">
                                <i class="fa-solid fa-money-bill-transfer card-icon"></i>
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                {{-- Default content if no specific role matches --}}
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