@extends('layouts.app')

@section('title', 'Laporkan Re-Upload')

@section('content')
<div class="max-w-2xl mx-auto">
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
            <h2 class="text-white font-bold flex items-center">
                <i class="fas fa-upload mr-2"></i> Laporkan Re-Upload
            </h2>
        </div>
        
        <div class="p-6">
            <!-- Info Konten -->
            <div class="bg-blue-50 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-blue-800 mb-2 flex items-center">
                    <i class="fas fa-info-circle mr-1"></i> Informasi Konten
                </h3>
                <div class="text-sm space-y-1">
                    <p><span class="text-gray-600">Bulan:</span> <strong>{{ date('F Y', strtotime($konten->month_year)) }}</strong></p>
                    <p><span class="text-gray-600">Platform:</span> <strong class="capitalize">{{ $konten->platform }}</strong></p>
                    <p><span class="text-gray-600">Deadline:</span> <strong>{{ date('d F Y', strtotime($konten->deadline_date)) }}</strong></p>
                    <p><span class="text-gray-600">Konten Asli:</span> 
                        <a href="{{ $konten->original_link }}" target="_blank" class="text-blue-600 hover:underline">Buka Link</a>
                    </p>
                </div>
            </div>
            
            <!-- Form -->
            <form method="POST" action="{{ route('karyawan.reupload.store', $konten->id) }}">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-gray-700 font-medium mb-2">
                        <i class="fab fa-facebook text-blue-600 mr-1"></i> Link Hasil Re-Upload <span class="text-red-500">*</span>
                    </label>
                    <input type="url" name="uploaded_link" required 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="https://facebook.com/... atau https://instagram.com/...">
                    <p class="text-xs text-gray-500 mt-1">Masukkan link postingan yang sudah Anda share ulang</p>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-calendar-alt mr-1"></i> Tanggal Upload <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="uploaded_at" required 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           value="{{ date('Y-m-d') }}">
                </div>
                
                <div class="flex gap-3">
                    <a href="{{ route('dashboard') }}" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 rounded-lg transition text-center">
                        Batal
                    </a>
                    <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Kirim Laporan
                    </button>
                </div>
            </form>
            
            <!-- Catatan -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 font-medium mb-2">
                    <i class="fas fa-lightbulb text-yellow-500 mr-1"></i> Catatan Penting:
                </p>
                <ul class="text-xs text-gray-500 space-y-1 list-disc list-inside">
                    <li>Pastikan link yang Anda masukkan benar dan dapat diakses publik</li>
                    <li>Laporan akan diverifikasi oleh admin</li>
                    <li>Status "Aktif" baru diberikan setelah diverifikasi</li>
                    <li>Hubungi admin jika ada kendala</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection