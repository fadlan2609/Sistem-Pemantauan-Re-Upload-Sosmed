@extends('layouts.app')

@section('title', 'Kelola Konten')

@section('content')
<div class="max-w-6xl mx-auto">
    
    <!-- Breadcrumb Navigation -->
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700">Kelola Konten</span>
    </div>
    
    <div class="flex justify-between items-center flex-wrap gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-file-alt text-green-500 mr-3"></i> Kelola Konten Wajib
        </h1>
        <div class="flex gap-3">
            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2.5 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('admin.konten.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Konten
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bulan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platform</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deadline</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dibuat</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($konten as $item)
                        @php
                            $isActive = $item->month_year->format('Y-m') == date('Y-m');
                        @endphp
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $item->month_year->format('F Y') }}
                                @if($isActive)
                                    <span class="ml-2 bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full">Aktif</span>
                                @endif
                             </td>
                            <td class="px-6 py-4 capitalize">
                                @if($item->platform == 'facebook')
                                    <i class="fab fa-facebook text-blue-600 mr-1"></i>
                                @elseif($item->platform == 'instagram')
                                    <i class="fab fa-instagram text-pink-600 mr-1"></i>
                                @else
                                    <i class="fab fa-whatsapp text-green-600 mr-1"></i>
                                @endif
                                {{ $item->platform }}
                            </td>
                            <td class="px-6 py-4 {{ strtotime($item->deadline_date) < time() ? 'text-red-600' : 'text-green-600' }}">
                                {{ $item->deadline_date->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if(strtotime($item->deadline_date) < time())
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">Lewat</span>
                                @else
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-sm">{{ $item->creator->name ?? 'Admin' }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ route('admin.konten.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.konten.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus" onclick="return confirm('Hapus konten bulan {{ $item->month_year->format('F Y') }}?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-folder-open text-4xl mb-3 block"></i>
                                Belum ada konten
                                <p class="text-sm mt-1">Silakan tambah konten wajib</p>
                                <a href="{{ route('admin.konten.create') }}" class="inline-block mt-3 bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                                    <i class="fas fa-plus"></i> Tambah Konten Sekarang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection