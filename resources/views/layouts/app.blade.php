<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Global Font and Custom Colors */
            body {
                font-family: 'Poppins', sans-serif !important;
                background-color: #f8f9fa; /* Latar belakang abu-abu sangat terang */
            }

            /* MSA Custom Colors dengan !important untuk override Tailwind */
            .text-msa-blue {
                color: #202060 !important;
            }
            .bg-msa-blue-50 {
                background-color: #e0e0f0 !important;
            }
            .bg-msa-blue-100 {
                background-color: #c0c0e0 !important;
            }
            .bg-msa-blue {
                background-color: #202060 !important;
            }
            .bg-msa-blue-light {
                background-color: #4F80FF !important;
            }
            .border-msa-blue-200 {
                border-color: #a0a0d0 !important;
            }
            .hover\:text-msa-blue-darker:hover {
                color: #101040 !important;
            }
            .hover\:bg-msa-blue-dark:hover {
                background-color: #101040 !important;
            }
            .text-msa-blue-700 {
                color: #202060 !important;
            }
            .text-msa-blue-900 {
                color: #101040 !important;
            }
            .bg-msa-blue-200 {
                background-color: #c0c0e0 !important;
            }

            /* Custom Logo Size */
            .logo-msa {
                height: 2.25rem !important; /* Ukuran standar 36px */
                width: auto !important;
                object-fit: contain !important;
                transition: transform 0.2s ease-in-out; /* Transisi untuk hover */
            }
            .logo-msa:hover {
                transform: scale(1.05); /* Efek zoom ringan saat hover */
            }

            /* App Title Styling */
            .app-title {
                font-size: 1.5rem !important; /* Ukuran standar 24px */
                font-weight: 700 !important; /* Cukup tebal */
                line-height: 1.2 !important;
                color: #202060; /* Warna teks biru MSA */
            }

            /* Navigation Bar Styling */
            nav.bg-white {
                background-color: #ffffff !important;
                border-bottom: 1px solid #e0e0e0 !important; /* Border bawah tipis */
                box-shadow: 0 2px 8px rgba(0,0,0,0.05); /* Bayangan lembut */
                position: sticky;
                top: 0;
                z-index: 1000;
                border-radius: 0; /* Menghilangkan border-radius pada nav bar */
            }

            .nav-height {
                height: 4rem !important; /* Tinggi standar 64px */
            }

            /* Main navigation flex container */
            .main-nav-container {
                display: flex;
                justify-content: space-between; /* Memisahkan logo/menu dan tombol auth */
                align-items: center;
                height: 100%; /* Memastikan mengisi tinggi nav-height */
            }

            /* Left side: Logo and Nav Links */
            .nav-left-section {
                display: flex;
                align-items: center;
                gap: 2.5rem; /* Jarak antara logo dan menu navigasi */
            }

            .nav-brand {
                flex-shrink: 0; /* Mencegah logo menyusut */
            }

            /* Nav Link Styling */
            .space-x-8.sm\:flex > a { /* Target x-nav-link */
                padding: 0.5rem 0.75rem; /* Padding nyaman */
                border-radius: 6px; /* Sudut membulat ringan */
                transition: all 0.2s ease-in-out; /* Transisi halus */
                font-weight: 500; /* Ketebalan standar */
                color: #4a5568; /* Warna teks default yang lebih netral */
            }

            .space-x-8.sm\:flex > a:hover {
                background-color: #f0f0f0 !important; /* Background abu-abu terang saat hover */
                color: #202060 !important; /* Warna teks biru MSA saat hover */
            }

            .space-x-8.sm\:flex > a.active {
                background-color: #e0e0f0 !important; /* Background untuk link aktif */
                color: #202060 !important; /* Warna teks aktif */
                font-weight: 600; /* Lebih tebal saat aktif */
                border-bottom: 2px solid #4F80FF !important; /* Garis bawah biru */
            }

            /* Auth Buttons (Login/Register) */
            .auth-buttons-container { /* Class baru untuk flex container tombol auth */
                display: flex;
                gap: 0.75rem; /* Jarak antar tombol */
            }

            .auth-buttons-container a {
                padding: 0.6rem 1.2rem !important; /* Padding nyaman */
                border-radius: 8px !important; /* Sudut membulat */
                font-weight: 600 !important; /* Cukup tebal */
                transition: all 0.2s ease-in-out; /* Transisi halus */
                text-transform: uppercase;
                letter-spacing: 0.025em;
            }

            .auth-buttons-container a.bg-msa-blue-light {
                background-color: #4F80FF !important; /* Warna solid */
                box-shadow: 0 3px 10px rgba(79, 128, 255, 0.2); /* Bayangan lembut */
            }
            .auth-buttons-container a.bg-msa-blue-light:hover {
                background-color: #357abd !important; /* Warna sedikit lebih gelap saat hover */
                box-shadow: 0 5px 15px rgba(79, 128, 255, 0.3);
                transform: translateY(-1px); /* Efek naik sangat ringan */
            }

            .auth-buttons-container a.bg-white {
                border: 1px solid #4F80FF !important; /* Border biru */
                color: #4F80FF !important; /* Teks biru */
            }
            .auth-buttons-container a.bg-white:hover {
                background-color: #4F80FF !important;
                color: white !important;
                transform: translateY(-1px);
                box-shadow: 0 5px 15px rgba(79, 128, 255, 0.2);
            }

            /* User Dropdown Trigger */
            .user-dropdown-trigger button { /* Class baru untuk trigger dropdown */
                padding: 0.5rem 0.8rem !important; /* Padding lebih kecil */
                border-radius: 6px !important;
                background-color: #ffffff !important;
                border: 1px solid #e0e0e0 !important;
                transition: all 0.2s ease-in-out;
            }
            .user-dropdown-trigger button:hover {
                background-color: #f0f0f0 !important;
                transform: translateY(-1px);
                box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            }
            .user-dropdown-trigger button div {
                font-weight: 500; /* Ketebalan standar */
            }

            /* Responsive Menu */
            .hidden.sm\:hidden .pt-2.pb-3.space-y-1 a { /* Target responsive-nav-link */
                padding: 0.75rem 1.5rem !important;
                border-radius: 6px;
                transition: all 0.2s ease;
                color: #4a5568 !important; /* Warna teks default */
            }
            .hidden.sm\:hidden .pt-2.pb-3.space-y-1 a:hover {
                background-color: #f0f0f0 !important;
                color: #202060 !important;
            }
            .hidden.sm\:hidden .pt-2.pb-3.space-y-1 a.active {
                background-color: #e0e0f0 !important;
                color: #202060 !important;
                font-weight: 600;
            }

            /* Mobile Login/Register Buttons */
            .mobile-auth-buttons-container { /* Class baru untuk tombol auth mobile */
                padding: 1rem 1rem 0.5rem 1rem; /* Padding atas-bawah dan samping */
                border-top: 1px solid #e0e0e0; /* Border atas */
            }

            .mobile-auth-buttons-container a {
                padding: 0.75rem 1rem !important;
                border-radius: 8px !important;
                font-weight: 600 !important;
                text-transform: uppercase;
                letter-spacing: 0.025em;
                transition: all 0.2s ease;
            }
            .mobile-auth-buttons-container a.bg-msa-blue-light {
                background-color: #4F80FF !important;
                box-shadow: 0 2px 8px rgba(79, 128, 255, 0.2);
            }
            .mobile-auth-buttons-container a.bg-white {
                border: 1px solid #4F80FF !important;
                color: #4F80FF !important;
            }

            /* Responsive adjustments */
            @media (max-width: 640px) {
                .app-title {
                    font-size: 1.25rem !important; /* 20px di mobile */
                }
                .logo-msa {
                    height: 2rem !important; /* 32px di mobile */
                }
                .nav-height {
                    height: 3.5rem !important; /* Lebih ringkas di mobile */
                }
                .nav-left-section {
                    gap: 1.5rem; /* Kurangi jarak di mobile */
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center nav-height">
                        <!-- Logo dan Nama Aplikasi di ujung kiri -->
                        <div class="nav-left-section"> {{-- Menggunakan class baru --}}
                            <div class="shrink-0 flex items-center nav-brand">
                                <a href="{{ route('dashboard') }}" class="flex items-center">
                                    <img src="{{ asset('img/msa.png') }}" alt="MSA Logo" class="logo-msa mr-3">
                                    <span class="app-title text-msa-blue">Credit Smart</span>
                                </a>
                            </div>

                            <!-- Menu Navigation -->
                            <div class="hidden space-x-8 sm:flex">
                                @guest
                                    {{-- Hanya tampil untuk pengunjung umum --}}
                                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                                        {{ __('Beranda') }}
                                    </x-nav-link>
                                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                                        {{ __('Tentang Kami') }}
                                    </x-nav-link>
                                    <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                                        {{ __('Kontak') }}
                                    </x-nav-link>
                                @endguest

                                @auth
                                    {{-- Tampilkan menu dashboard sesuai role --}}
                                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                        {{ __('Dashboard') }}
                                    </x-nav-link>

                                    @role('Admin')
                                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                                            {{ __('Manajemen Pengguna') }}
                                        </x-nav-link>
                                        <x-nav-link :href="route('economic-sectors.index')" :active="request()->routeIs('economic-sectors.index')">
                                            {{ __('Sektor Ekonomi') }}
                                        </x-nav-link>
                                    @endrole

                                    @role('Admin|Direksi|Kepala Bagian Kredit|Teller')
                                        <x-nav-link :href="route('applications.index')" :active="request()->routeIs('applications.index')">
                                            {{ __('Kredit') }}
                                        </x-nav-link>
                                    @endrole

                                    @role('Admin|Direksi')
                                        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')">
                                            {{ __('Laporan & Analisis') }}
                                        </x-nav-link>
                                    @endrole
                                @endauth
                            </div>
                        </div>

                        <!-- Button Login/Register atau User Dropdown (Right side) -->
                        <div class="hidden sm:flex sm:items-center sm:ml-6 auth-buttons-container"> {{-- Menggunakan class baru --}}
                            @guest
                                <!-- Button Login dan Register untuk Tamu -->
                                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-msa-blue-light border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-msa-blue-dark focus:outline-none focus:border-msa-blue-dark focus:ring focus:ring-blue-200 active:bg-msa-blue-dark disabled:opacity-25 transition">
                                    {{ __('Login') }}
                                </a>
                                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-white border border-msa-blue-light rounded-md font-semibold text-xs text-msa-blue-light uppercase tracking-widest hover:bg-msa-blue-50 focus:outline-none focus:border-msa-blue-dark focus:ring focus:ring-blue-200 active:bg-msa-blue-50 disabled:opacity-25 transition">
                                    {{ __('Register') }}
                                </a>
                            @else
                                <!-- User Dropdown untuk yang sudah login -->
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 user-dropdown-trigger"> {{-- Class baru --}}
                                            <div>{{ Auth::user()->name }}</div>
                                            <div class="ml-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endauth
                        </div>

                        <!-- Mobile menu button -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Responsive Menu --}}
                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        @guest
                            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                                {{ __('Beranda') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                                {{ __('Tentang Kami') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                                {{ __('Kontak') }}
                            </x-responsive-nav-link>
                        @endguest

                        @auth
                            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-responsive-nav-link>

                            @role('Admin')
                                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                                    {{ __('Manajemen Pengguna') }}
                                </x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('economic-sectors.index')" :active="request()->routeIs('economic-sectors.index')">
                                    {{ __('Sektor Ekonomi') }}
                                </x-responsive-nav-link>
                            @endrole

                            @role('Admin|Direksi|Kepala Bagian Kredit|Teller')
                                <x-responsive-nav-link :href="route('applications.index')" :active="request()->routeIs('applications.index')">
                                    {{ __('Kredit') }}
                                </x-responsive-nav-link>
                            @endrole

                            @role('Admin|Direksi')
                                <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')">
                                    {{ __('Laporan & Analisis') }}
                                </x-responsive-nav-link>
                            @endrole
                        @endauth
                    </div>

                    <!-- Mobile User Section -->
                    <div class="pt-4 pb-1 mobile-auth-buttons-container"> {{-- Menggunakan class baru --}}
                        @guest
                            <!-- Mobile Login/Register Buttons -->
                            <div class="space-y-2">
                                <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 bg-msa-blue-light border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-msa-blue-dark focus:outline-none transition">
                                    {{ __('Login') }}
                                </a>
                                <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 bg-white border border-msa-blue-light rounded-md font-semibold text-xs text-msa-blue-light uppercase tracking-widest hover:bg-msa-blue-50 focus:outline-none transition">
                                    {{ __('Register') }}
                                </a>
                            </div>
                        @else
                            <!-- Mobile User Info -->
                            <div class="px-4">
                                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <x-responsive-nav-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-responsive-nav-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-responsive-nav-link>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </nav>

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
