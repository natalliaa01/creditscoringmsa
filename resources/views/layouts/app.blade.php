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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> {{-- Font Awesome untuk ikon --}}


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Custom CSS untuk warna biru logo */
            .text-msa-blue {
                color: #202060; /* Warna biru gelap dari logo MSA */
            }
            .bg-msa-blue-50 {
                background-color: #e0e0f0; /* Biru muda yang disesuaikan */
            }
            .bg-msa-blue-100 {
                background-color: #c0c0e0; /* Biru sedang yang disesuaikan */
            }
            .border-msa-blue-200 {
                border-color: #a0a0d0; /* Border biru yang disesuaikan */
            }
            .hover\:text-msa-blue-darker:hover {
                color: #101040; /* Biru lebih gelap saat hover */
            }
            .text-msa-blue-700 {
                color: #202060; /* Biru gelap untuk teks */
            }
            .text-msa-blue-900 {
                color: #101040; /* Biru sangat gelap untuk teks */
            }
            .bg-msa-blue-200 {
                background-color: #c0c0e0; /* Biru muda untuk badge */
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo dan Nama Aplikasi -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('dashboard') }}" class="flex items-center">
                                    {{-- Logo MSA dari folder public/img --}}
                                    <img src="{{ asset('img/msa.png') }}" alt="MSA Logo" class="block h-9 w-auto object-contain mr-2"> {{-- Menambah object-contain --}}
                                    <span class="text-2xl font-bold text-msa-blue">Aplikasi Credit Scoring</span> {{-- Menggunakan custom class --}}
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-msa-blue-700 hover:text-msa-blue-darker">
                                    {{ __('Dashboard') }}
                                </x-nav-link>

                                {{-- Menu Navigasi Berdasarkan Peran --}}
                                @role('Admin')
                                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="text-msa-blue-700 hover:text-msa-blue-darker">
                                        {{ __('Manajemen Pengguna') }}
                                    </x-nav-link>
                                    <x-nav-link :href="route('economic-sectors.index')" :active="request()->routeIs('economic-sectors.index')" class="text-msa-blue-700 hover:text-msa-blue-darker">
                                        {{ __('Data Master') }}
                                    </x-nav-link>
                                @endrole

                                @role('Admin|Direksi|Kepala Bagian Kredit|Teller')
                                    <x-nav-link :href="route('applications.index')" :active="request()->routeIs('applications.index')" class="text-msa-blue-700 hover:text-msa-blue-darker">
                                        {{ __('Aplikasi Kredit') }}
                                    </x-nav-link>
                                @endrole

                                @role('Admin|Direksi|Kepala Bagian Kredit|Teller') {{-- Hanya peran yang bisa melihat draft --}}
                                    <x-nav-link :href="route('applications.drafts')" :active="request()->routeIs('applications.drafts')" class="text-msa-blue-700 hover:text-msa-blue-darker">
                                        {{ __('Draft Aplikasi') }}
                                    </x-nav-link>
                                @endrole

                                @role('Admin|Direksi')
                                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" class="text-msa-blue-700 hover:text-msa-blue-darker">
                                        {{ __('Laporan & Analisis') }}
                                    </x-nav-link>
                                @endrole
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
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

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <!-- Hamburger -->
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

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-msa-blue-700 hover:text-msa-blue-darker">
                            {{ __('Dashboard') }}
                        </x-responsive-nav-link>

                        {{-- Menu Navigasi Responsif Berdasarkan Peran --}}
                        @role('Admin')
                            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="text-msa-blue-700 hover:text-msa-blue-darker">
                                {{ __('Manajemen Pengguna') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('economic-sectors.index')" :active="request()->routeIs('economic-sectors.index')" class="text-msa-blue-700 hover:text-msa-blue-darker">
                                {{ __('Data Master') }}
                            </x-responsive-nav-link>
                        @endrole

                        @role('Admin|Direksi|Kepala Bagian Kredit|Teller')
                            <x-responsive-nav-link :href="route('applications.index')" :active="request()->routeIs('applications.index')" class="text-msa-blue-700 hover:text-msa-blue-darker">
                                {{ __('Aplikasi Kredit') }}
                            </x-responsive-nav-link>
                        @endrole

                        @role('Admin|Direksi|Kepala Bagian Kredit|Teller')
                            <x-responsive-nav-link :href="route('applications.drafts')" :active="request()->routeIs('applications.drafts')" class="text-msa-blue-700 hover:text-msa-blue-darker">
                                {{ __('Draft Aplikasi') }}
                            </x-responsive-nav-link>
                        @endrole

                        @role('Admin|Direksi')
                            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')" class="text-msa-blue-700 hover:text-msa-blue-darker">
                                {{ __('Laporan & Analisis') }}
                            </x-responsive-nav-link>
                        @endrole
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <x-responsive-nav-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-responsive-nav-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Page Heading dihapus dari sini --}}
            {{-- @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif --}}

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
