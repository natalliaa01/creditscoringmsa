<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengguna') }} {{-- Mengubah judul header --}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    {{-- Mengubah judul section untuk edit user --}}
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Pengguna #{{ $user->id }}</h3>

                    {{-- Pesan sukses/error --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            <ul>
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

                        {{-- Nama Lengkap (menggantikan Nama Pemohon) --}}
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Email Pengguna (bidang baru untuk user) --}}
                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Peran Pengguna (jika Anda menggunakan Spatie/Laravel-Permission) --}}
                        {{-- Asumsi Anda ingin mengizinkan perubahan peran di sini --}}
                        @if (isset($roles) && $roles->isNotEmpty())
                            <div class="mb-4">
                                <x-input-label for="roles" :value="__('Peran')" />
                                <select id="roles" name="roles[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" multiple>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ in_array($role->name, old('roles', $user->getRoleNames()->toArray())) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                            </div>
                        @endif

                        {{-- Hapus bagian form aplikasi kredit yang tidak relevan --}}
                        {{-- Bagian "Tipe Aplikasi", "Status Aplikasi", "Form UMKM/Pengusaha", dan "Form Pegawai" --}}
                        {{-- Dihapus karena tidak ada di model User dan akan menyebabkan error "Undefined property" --}}
                        {{-- Jika Anda ingin mempertahankan struktur yang serupa, Anda perlu menambahkan bidang-bidang yang relevan dengan User di sini. --}}

                        <div class="flex items-center justify-end mt-4">
                            {{-- Mengubah link batal agar kembali ke daftar pengguna --}}
                            <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button class="ml-3">
                                {{ __('Perbarui Pengguna') }} {{-- Mengubah teks tombol --}}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
