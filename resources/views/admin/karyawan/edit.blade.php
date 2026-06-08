@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="max-w-2xl mx-auto">
    
    <!-- Breadcrumb Navigation -->
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('admin.karyawan') }}" class="hover:text-blue-600">Kelola Karyawan</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700">Edit Karyawan</span>
    </div>
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-600 to-orange-600 px-6 py-4 flex justify-between items-center">
            <h2 class="text-white font-bold flex items-center">
                <i class="fas fa-user-edit mr-2"></i> Edit Karyawan
            </h2>
            <a href="{{ route('admin.karyawan') }}" class="bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-lg transition text-sm">
                <i class="fas fa-times"></i> Tutup
            </a>
        </div>
        
        <div class="p-6">
            <form method="POST" action="{{ route('admin.karyawan.update', $karyawan->id) }}">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama Lengkap -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ $karyawan->name }}" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ $karyawan->email }}" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <!-- Password (Opsional) -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            Password <span class="text-gray-400 text-sm">(kosongkan jika tidak diubah)</span>
                        </label>
                        <input type="password" name="password" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <p class="text-xs text-gray-500 mt-1">Isi hanya jika ingin mengganti password</p>
                    </div>
                    
                    <!-- Cabang -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            Cabang <span class="text-red-500">*</span>
                        </label>
                        <select name="cabang" required 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="Pusat" {{ $karyawan->cabang == 'Pusat' ? 'selected' : '' }}>🏢 Pusat (Kantor Pusat)</option>
                            <option value="Pematangsiantar" {{ $karyawan->cabang == 'Pematangsiantar' ? 'selected' : '' }}>📍 Pematangsiantar</option>
                            <option value="Sidamanik" {{ $karyawan->cabang == 'Sidamanik' ? 'selected' : '' }}>📍 Sidamanik</option>
                            <option value="Perdagangan" {{ $karyawan->cabang == 'Perdagangan' ? 'selected' : '' }}>📍 Perdagangan</option>
                            <option value="Kisaran" {{ $karyawan->cabang == 'Kisaran' ? 'selected' : '' }}>📍 Kisaran</option>
                            <option value="Stabat" {{ $karyawan->cabang == 'Stabat' ? 'selected' : '' }}>📍 Stabat</option>
                        </select>
                    </div>
                    
                    <!-- Facebook URL -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            <i class="fab fa-facebook text-blue-600 mr-1"></i> Facebook URL
                        </label>
                        <input type="url" name="fb_url" value="{{ $karyawan->fb_url }}" placeholder="https://facebook.com/username" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <!-- Instagram URL -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            <i class="fab fa-instagram text-pink-600 mr-1"></i> Instagram URL
                        </label>
                        <input type="url" name="ig_url" value="{{ $karyawan->ig_url }}" placeholder="https://instagram.com/username" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <!-- WhatsApp Number -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            <i class="fab fa-whatsapp text-green-600 mr-1"></i> WhatsApp Number
                        </label>
                        <input type="text" name="wa_number" value="{{ $karyawan->wa_number }}" placeholder="08123456789" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                </div>
                
                <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.karyawan') }}" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2.5 rounded-lg transition text-center">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <button type="submit" 
                            class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2.5 rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Update Karyawan
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Informasi Tambahan -->
    <div class="mt-4 p-3 bg-yellow-50 rounded-lg">
        <p class="text-xs text-yellow-700">
            <i class="fas fa-shield-alt mr-1"></i> 
            Biarkan password kosong jika tidak ingin mengubah password karyawan.
        </p>
    </div>
</div>
@endsection