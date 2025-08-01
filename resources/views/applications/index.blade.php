<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Aplikasi Kredit') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100"> {{-- Latar belakang halaman menjadi abu-abu --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Aplikasi Kredit</h3>
                        @can('create credit application')
                            <a href="{{ route('applications.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Ajukan Aplikasi Baru') }}
                            </a>
                        @endcan
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Search Bar --}}
                    <div class="mb-4">
                        <form method="GET" action="{{ route('applications.index') }}">
                            <div class="flex items-center">
                                <x-text-input type="text" name="search" placeholder="Cari nama pemohon atau NIK..." class="w-full mr-2" value="{{ request('search') }}" />
                                <x-primary-button type="submit">
                                    {{ __('Cari') }}
                                </x-primary-button>
                                @if(request('search'))
                                    <a href="{{ route('applications.index') }}" class="ml-2 px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('Reset') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    @if ($applications->isEmpty())
                        <p class="text-gray-600">Belum ada aplikasi kredit yang tersedia.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No.
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Pemohon
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tipe Aplikasi
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Diajukan Oleh
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal Pengajuan
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Aksi</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($applications as $application)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $loop->iteration }} {{-- Menggunakan nomor urut --}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $application->applicant_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $application->application_type }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{
                                                    $application->status === 'Approved' ? 'bg-green-100 text-green-800' :
                                                    ($application->status === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')
                                                }}">
                                                    {{ $application->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $application->user->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $application->created_at->format('d M Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('applications.show', $application->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2" title="Lihat Detail">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @can('edit credit application')
                                                    @if ($application->status !== 'Approved' && $application->status !== 'Rejected')
                                                        <a href="{{ route('applications.edit', $application->id) }}" class="text-blue-600 hover:text-blue-900 mr-2" title="Edit Aplikasi">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                    @endif
                                                @endcan
                                                @can('delete credit application')
                                                    @if ($application->status !== 'Approved' && $application->status !== 'Rejected')
                                                        <form id="delete-form-{{ $application->id }}" action="{{ route('applications.destroy', $application->id) }}" method="POST" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" onclick="showConfirmationModal('deleteModal', 'Konfirmasi Hapus Aplikasi', 'Apakah Anda yakin ingin menghapus aplikasi ini?', document.getElementById('delete-form-{{ $application->id }}'))" class="text-red-600 hover:text-red-900" title="Hapus Aplikasi">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endcan
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

    {{-- Include the custom confirmation modal component for delete --}}
    <x-confirmation-modal id="deleteModal" />
</x-app-layout>
