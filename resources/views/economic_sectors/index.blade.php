<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Sektor Ekonomi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6 border-t-4 border-blue-500">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6"> {{-- Removed border-b and pb-4 --}}
                        <h3 class="text-2xl font-bold text-gray-800">Daftar Sektor Ekonomi</h3>
                        <a href="{{ route('economic-sectors.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <i class="fas fa-plus mr-2"></i>
                            {{ __('Tambah Sektor Baru') }}
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-400 text-green-700 rounded-lg shadow-sm flex items-center">
                            <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($sectors->isEmpty())
                        <div class="text-center py-10 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-gray-600 text-lg">Belum ada sektor ekonomi yang terdaftar.</p>
                            <p class="text-gray-500 text-sm mt-2">Klik "Tambah Sektor Baru" untuk memulai.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto shadow-md sm:rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">
                                            Nama Sektor
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">
                                            Deskripsi
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-blue-700 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($sectors as $sector)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $sector->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{ $sector->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-normal text-sm text-gray-700 max-w-sm">
                                                {{ $sector->description ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <a href="{{ route('economic-sectors.edit', $sector->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4 font-medium">
                                                    Edit
                                                </a>
                                                <form action="{{ route('economic-sectors.destroy', $sector->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sektor ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>