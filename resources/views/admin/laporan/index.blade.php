@extends('layouts.app')

@section('title', 'Laporan Bulanan')

@section('content')
<div class="max-w-2xl mx-auto">
    
    <!-- Breadcrumb Navigation -->
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('dashboard') }}" class="hover:text-purple-600">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700">Laporan Bulanan</span>
    </div>
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-white font-bold flex items-center text-xl">
                        <i class="fas fa-chart-line mr-2"></i> Generate Laporan Bulanan
                    </h2>
                    <p class="text-purple-100 text-sm mt-1">Pilih periode dan cabang untuk membuat laporan re-upload</p>
                </div>
                <a href="{{ route('dashboard') }}" class="bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-lg transition text-sm flex items-center gap-1">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </div>
        </div>
        
        <!-- Form -->
        <div class="p-6">
            <form method="POST" action="{{ route('admin.laporan.generate') }}">
                @csrf
                
                <!-- Pilih Bulan -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-calendar-alt text-purple-500 mr-1"></i> Pilih Bulan
                    </label>
                    <select name="bulan" required 
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        <option value="">-- Pilih Bulan --</option>
                        @foreach($bulanTersedia as $b)
                            <option value="{{ $b->month_year }}" {{ old('bulan') == $b->month_year ? 'selected' : '' }}>
                                📅 {{ date('F Y', strtotime($b->month_year)) }}
                            </option>
                        @endforeach
                    </select>
                    @if($bulanTersedia->isEmpty())
                        <div class="mt-2 p-3 bg-red-50 border-l-4 border-red-500 rounded">
                            <p class="text-red-700 text-sm">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Belum ada konten. Silakan buat konten terlebih dahulu melalui menu Kelola Konten.
                            </p>
                            <a href="{{ route('admin.konten.create') }}" class="inline-block mt-2 text-red-600 hover:text-red-800 text-sm">
                                <i class="fas fa-plus"></i> Buat Konten Sekarang
                            </a>
                        </div>
                    @endif
                </div>
                
                <!-- Pilih Cabang (6 Pilihan + Semua) -->
                <div class="mb-8">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-building text-purple-500 mr-1"></i> Pilih Cabang
                    </label>
                    <select name="cabang" required 
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        <option value="semua" {{ old('cabang') == 'semua' ? 'selected' : '' }}>
                            🌍 Semua Cabang
                        </option>
                        <option value="Pusat" {{ old('cabang') == 'Pusat' ? 'selected' : '' }}>
                            🏢 Pusat (Kantor Pusat)
                        </option>
                        <option value="Pematangsiantar" {{ old('cabang') == 'Pematangsiantar' ? 'selected' : '' }}>
                            📍 Pematangsiantar
                        </option>
                        <option value="Sidamanik" {{ old('cabang') == 'Sidamanik' ? 'selected' : '' }}>
                            📍 Sidamanik
                        </option>
                        <option value="Perdagangan" {{ old('cabang') == 'Perdagangan' ? 'selected' : '' }}>
                            📍 Perdagangan
                        </option>
                        <option value="Kisaran" {{ old('cabang') == 'Kisaran' ? 'selected' : '' }}>
                            📍 Kisaran
                        </option>
                        <option value="Stabat" {{ old('cabang') == 'Stabat' ? 'selected' : '' }}>
                            📍 Stabat
                        </option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>
                        Pilih "Semua Cabang" untuk laporan gabungan seluruh cabang
                    </p>
                </div>
                
                <!-- Tombol Aksi -->
                <div class="flex gap-3">
                    <a href="{{ route('dashboard') }}" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 rounded-lg transition text-center">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold py-3 rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-download"></i> Generate Laporan
                    </button>
                </div>
            </form>
            
            <!-- Informasi Panduan -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-sm text-gray-700 font-semibold mb-2 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-1"></i> Panduan Laporan:
                </p>
                <ul class="text-xs text-gray-600 space-y-1 list-disc list-inside ml-2">
                    <li>Laporan hanya tersedia untuk bulan yang sudah memiliki konten wajib</li>
                    <li>Karyawan dihitung <span class="font-semibold text-green-600">AKTIF</span> jika sudah re-upload dan diverifikasi admin</li>
                    <li>Karyawan dihitung <span class="font-semibold text-red-600">TIDAK AKTIF</span> jika belum re-upload atau belum diverifikasi</li>
                    <li>Setelah generate, Anda bisa mengekspor laporan ke format <strong>PDF</strong> atau <strong>Excel</strong></li>
                    <li>Laporan dapat digunakan sebagai arsip dan evaluasi bulanan</li>
                </ul>
            </div>
            
            <!-- Catatan Penting -->
            <div class="mt-4 p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-400">
                <p class="text-xs text-yellow-800">
                    <i class="fas fa-lightbulb text-yellow-500 mr-1"></i>
                    <strong>Catatan:</strong> Pastikan data karyawan sudah lengkap sebelum generate laporan. 
                    Jika ada karyawan yang belum memiliki akun, silakan tambah terlebih dahulu melalui menu Kelola Karyawan.
                </p>
            </div>
        </div>
    </div>
    
    <!-- Daftar Bulan Tersedia -->
    @if($bulanTersedia->isNotEmpty())
        <div class="mt-6 bg-white rounded-xl shadow-md p-4">
            <h4 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                <i class="fas fa-list text-purple-500 mr-1"></i> Bulan dengan Konten Tersedia:
            </h4>
            <div class="flex flex-wrap gap-2">
                @foreach($bulanTersedia as $b)
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs">
                        {{ date('F Y', strtotime($b->month_year)) }}
                    </span>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection