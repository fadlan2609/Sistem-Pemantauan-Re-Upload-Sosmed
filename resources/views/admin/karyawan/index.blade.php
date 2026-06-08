@extends('layouts.app')

@section('title', 'Kelola Karyawan')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <!-- Breadcrumb Navigation -->
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700">Kelola Karyawan</span>
    </div>
    
    <div class="flex justify-between items-center flex-wrap gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-users text-blue-500 mr-3"></i> Kelola Karyawan
        </h1>
        <div class="flex gap-3">
            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2.5 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('admin.karyawan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Karyawan
            </a>
        </div>
    </div>
    
    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('admin.karyawan') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search by Name -->
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">
                    <i class="fas fa-search text-blue-500 mr-1"></i> Cari Nama
                </label>
                <div class="flex">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari berdasarkan nama..." 
                           class="flex-1 border border-gray-300 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-r-lg transition">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            
            <!-- Filter by Cabang -->
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">
                    <i class="fas fa-building text-blue-500 mr-1"></i> Filter Cabang
                </label>
                <select name="cabang" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                    <option value="">Semua Cabang</option>
                    <option value="Pusat" {{ request('cabang') == 'Pusat' ? 'selected' : '' }}>🏢 Pusat (Kantor Pusat)</option>
                    <option value="Pematangsiantar" {{ request('cabang') == 'Pematangsiantar' ? 'selected' : '' }}>📍 Pematangsiantar</option>
                    <option value="Sidamanik" {{ request('cabang') == 'Sidamanik' ? 'selected' : '' }}>📍 Sidamanik</option>
                    <option value="Perdagangan" {{ request('cabang') == 'Perdagangan' ? 'selected' : '' }}>📍 Perdagangan</option>
                    <option value="Kisaran" {{ request('cabang') == 'Kisaran' ? 'selected' : '' }}>📍 Kisaran</option>
                    <option value="Stabat" {{ request('cabang') == 'Stabat' ? 'selected' : '' }}>📍 Stabat</option>
                </select>
            </div>
            
            <!-- Reset Filter -->
            <div class="flex items-end">
                <a href="{{ route('admin.karyawan') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2 w-full justify-center">
                    <i class="fas fa-sync-alt"></i> Reset Filter
                </a>
            </div>
        </form>
    </div>
    
    <!-- Info Total Karyawan -->
    <div class="mb-4 flex justify-between items-center">
        <div class="text-sm text-gray-500">
            <i class="fas fa-database mr-1"></i> Total: <span class="font-semibold text-gray-700">{{ $karyawan->total() }}</span> karyawan
        </div>
        <div class="text-sm text-gray-500">
            @if(request('search'))
                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                    <i class="fas fa-search mr-1"></i> Pencarian: "{{ request('search') }}"
                </span>
            @endif
            @if(request('cabang'))
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs ml-2">
                    <i class="fas fa-building mr-1"></i> Cabang: {{ request('cabang') }}
                </span>
            @endif
        </div>
    </div>
    
    <!-- Tabel Karyawan -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cabang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Facebook</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Instagram</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">WhatsApp</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($karyawan as $index => $k)
                        <tr>
                            <td class="px-6 py-4 text-gray-500 text-sm">
                                {{ $karyawan->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 font-medium">{{ $k->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $k->email }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">
                                    @if($k->cabang == 'Pusat')
                                        🏢 {{ $k->cabang }}
                                    @else
                                        📍 {{ $k->cabang }}
                                    @endif
                                </span>
                            </td>
                            
                            <!-- Facebook Link -->
                            <td class="px-6 py-4">
                                @if($k->fb_url)
                                    <a href="{{ $k->fb_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
                                        <i class="fab fa-facebook text-blue-600"></i> Profile
                                    </a>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            
                            <!-- Instagram Link -->
                            <td class="px-6 py-4">
                                @if($k->ig_url)
                                    <a href="{{ $k->ig_url }}" target="_blank" class="text-pink-600 hover:text-pink-800 text-sm flex items-center gap-1">
                                        <i class="fab fa-instagram text-pink-600"></i> Profile
                                    </a>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            
                            <!-- WhatsApp Link -->
                            <td class="px-6 py-4">
                                @if($k->wa_number)
                                    @php
                                        $wa_number = preg_replace('/[^0-9]/', '', $k->wa_number);
                                        if (substr($wa_number, 0, 1) == '0') {
                                            $wa_number = '62' . substr($wa_number, 1);
                                        }
                                    @endphp
                                    <a href="https://wa.me/{{ $wa_number }}" target="_blank" class="text-green-600 hover:text-green-800 text-sm flex items-center gap-1">
                                        <i class="fab fa-whatsapp text-green-600"></i> {{ $k->wa_number }}
                                    </a>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ route('admin.karyawan.edit', $k->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.karyawan.destroy', $k->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus" onclick="return confirm('Yakin hapus {{ $k->name }}?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-users-slash text-4xl mb-3 block"></i>
                                <p>Tidak ada karyawan</p>
                                @if(request('search') || request('cabang'))
                                    <p class="text-sm mt-1">Tidak ada hasil yang sesuai dengan filter</p>
                                    <a href="{{ route('admin.karyawan') }}" class="inline-block mt-3 text-blue-600 hover:underline">
                                        <i class="fas fa-sync-alt"></i> Hapus Filter
                                    </a>
                                @else
                                    <p class="text-sm mt-1">Silakan tambah karyawan baru</p>
                                    <a href="{{ route('admin.karyawan.create') }}" class="inline-block mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                                        <i class="fas fa-plus"></i> Tambah Karyawan
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($karyawan->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $karyawan->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection