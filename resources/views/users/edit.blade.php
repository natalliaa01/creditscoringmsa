<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">
            {{ __('Edit Pengguna') }}
        </h2>
    </x-slot>

    {{-- Mengembalikan lebar dan padding div terluar, hanya mengubah background --}}
    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen"> {{-- Background gradien lembut --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> {{-- Lebar kontainer utama tetap 7xl --}}
            {{-- Meningkatkan bayangan, sedikit padding dan rounded --}}
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-lg p-8"> 
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-6">Edit Pengguna #{{ $user->id }}</h3>

                    {{-- Pesan sukses/error/validasi - Ditambahkan shadow dan ikon untuk visual --}}
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-400 text-green-800 rounded-lg shadow-sm flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-400 text-red-800 rounded-lg shadow-sm flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-400 text-red-800 rounded-lg shadow-sm">
                            <div class="font-bold mb-2">Terjadi kesalahan:</div>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form untuk memperbarui pengguna --}}
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Nama Lengkap --}}
                        <div class="mb-6"> {{-- Margin-bottom lebih baik --}}
                            <x-input-label for="name" :value="__('Nama Lengkap')" class="mb-2" /> {{-- Jarak label dari input --}}
                            <x-text-input id="name" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" type="text" name="name" :value="old('name', $user->name)" required autofocus /> {{-- Padding, shadow, focus biru, transisi --}}
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Email Pengguna --}}
                        <div class="mb-6">
                            <x-input-label for="email" :value="__('Email')" class="mb-2" />
                            <x-text-input id="email" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" type="email" name="email" :value="old('email', $user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Peran Pengguna --}}
                        @if (isset($roles) && $roles->isNotEmpty())
                            <div class="mb-8"> {{-- Margin-bottom lebih banyak untuk peran --}}
                                <x-input-label for="roles" :value="__('Peran')" class="mb-2" />
                                <select id="roles" name="roles[]" class="block w-full px-4 py-2 border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm appearance-none bg-white transition duration-150 ease-in-out" multiple>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ in_array($role->name, old('roles', $user->getRoleNames()->toArray())) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                            </div>
                        @endif

                        <div class="flex items-center justify-end mt-6 space-x-4"> {{-- Margin-top dan jarak antar tombol --}}
                            <a href="{{ route('users.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button class="px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                {{ __('Perbarui Pengguna') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>