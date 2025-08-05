<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Aplikasi Kredit') }}
        </h2>
    </x-slot>

    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-lg">
                <div class="p-6 sm:px-12 text-gray-900 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">Daftar Aplikasi Kredit</h3>
                        @can('create credit application')
                            <a href="{{ route('applications.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-105 shadow-md">
                                <i class="fas fa-plus-circle mr-2"></i>
                                {{ __('Ajukan Aplikasi Baru') }}
                            </a>
                        @endcan
                    </div>

                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-sm flex items-center animate-fade-in">
                            <i class="fas fa-check-circle w-5 h-5 mr-3 text-green-500"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="mb-6">
                        <form method="GET" action="{{ route('applications.index') }}">
                            <div class="flex items-center space-x-2">
                                <x-text-input type="text" name="search" placeholder="Cari nama pemohon atau NIK..." class="w-full text-sm border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm" value="{{ request('search') }}" />
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-search mr-2"></i>
                                    {{ __('Cari') }}
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('applications.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring ring-gray-300 transition ease-in-out duration-150">
                                        <i class="fas fa-sync-alt mr-2"></i>
                                        {{ __('Reset') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    @if ($applications->isEmpty())
                        <div class="text-center py-10 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 text-gray-500 shadow-inner">
                            <i class="fas fa-exclamation-circle fa-2x mb-4 text-gray-400"></i>
                            <p class="text-lg font-medium">Belum ada aplikasi kredit yang tersedia.</p>
                            <p class="text-sm mt-2">Silakan ajukan aplikasi baru untuk memulai.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto rounded-lg shadow-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-blue-600 text-white">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                            No.
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                            Nama Pemohon
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                            Tipe Aplikasi
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                            Diajukan Oleh
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                            Tanggal Pengajuan
                                        </th>
                                        <th scope="col" class="relative px-6 py-3 text-center text-xs font-bold uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($applications as $application)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{ $application->applicant_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{ $application->application_type }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusColor = 'yellow';
                                                    $statusText = 'Menunggu';
                                                    if ($application->status === 'Approved') {
                                                        $statusColor = 'green';
                                                        $statusText = 'Disetujui';
                                                    } elseif ($application->status === 'Rejected') {
                                                        $statusColor = 'red';
                                                        $statusText = 'Ditolak';
                                                    }
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{$statusColor}}-100 text-{{$statusColor}}-800 shadow-sm">
                                                    {{ $statusText }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{ $application->user->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ $application->created_at->format('d M Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <a href="{{ route('applications.show', $application->id) }}" class="text-blue-500 hover:text-blue-700 transition-colors duration-200" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @can('edit credit application')
                                                        @if ($application->status !== 'Approved' && $application->status !== 'Rejected')
                                                            <a href="{{ route('applications.edit', $application->id) }}" class="text-indigo-500 hover:text-indigo-700 transition-colors duration-200" title="Edit Aplikasi">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endif
                                                    @endcan
                                                    @can('delete credit application')
                                                        @if ($application->status !== 'Approved' && $application->status !== 'Rejected')
                                                            <form id="delete-form-{{ $application->id }}" action="{{ route('applications.destroy', $application->id) }}" method="POST" class="inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" onclick="showConfirmationModal('deleteModal', 'Konfirmasi Hapus Aplikasi', 'Apakah Anda yakin ingin menghapus aplikasi kredit ini secara permanen?', document.getElementById('delete-form-{{ $application->id }}'))" class="text-red-500 hover:text-red-700 transition-colors duration-200" title="Hapus Aplikasi">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endcan
                                                </div>
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
