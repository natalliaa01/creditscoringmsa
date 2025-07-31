<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Sektor Ekonomi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 border-t-4 border-indigo-600">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold text-indigo-700 mb-8 flex items-center"> {{-- Removed pb-4 and border-b border-gray-200 --}}
                        <i class="fas fa-plus-circle mr-3 text-indigo-500"></i>
                        Informasi Sektor Ekonomi Baru
                    </h3>

                    @if ($errors->any())
                        <div class="mb-8 p-4 bg-red-50 border border-red-400 text-red-700 rounded-lg shadow-sm flex items-start">
                            <svg class="w-5 h-5 mr-3 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <div>
                                <h4 class="font-semibold">Mohon Periksa Input Anda:</h4>
                                <ul class="mt-1 list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('economic-sectors.store') }}">
                        @csrf

                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Nama Sektor Ekonomi')" class="text-gray-700 font-medium mb-2" />
                            <x-text-input id="name" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm p-3 text-base" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Manufaktur, Pertanian" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <div class="mb-8">
                            <x-input-label for="description" :value="__('Deskripsi (Opsional)')" class="text-gray-700 font-medium mb-2" />
                            <textarea id="description" name="description" rows="5" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm p-3 text-base" placeholder="Jelaskan secara singkat tentang sektor ini...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-4">
                            <a href="{{ route('economic-sectors.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button class="ml-3 px-6 py-3 bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:ring-blue-500 shadow-md"> {{-- Changed to blue button --}}
                                <i class="fas fa-plus mr-2"></i>
                                {{ __('Tambah Sektor') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>