@extends('layouts.app')

@section('title', 'Login sebagai Karyawan')

@section('content')
<div class="max-w-6xl mx-auto">
    
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700">Login sebagai Karyawan</span>
    </div>
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-white font-bold flex items-center text-xl">
                        <i class="fas fa-user-astronaut mr-2"></i> Login sebagai Karyawan
                    </h2>
                    <p class="text-blue-100 text-sm mt-1">Masuk ke akun karyawan untuk melihat dan memverifikasi langsung</p>
                </div>
                <a href="{{ route('dashboard') }}" class="bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-lg transition text-sm">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Informasi -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                    <div>
                        <p class="text-blue-800 font-semibold">Fitur Login sebagai Karyawan</p>
                        <p class="text-blue-700 text-sm mt-1">
                            Dengan fitur ini, admin dapat masuk ke akun karyawan untuk:
                        </p>
                        <ul class="text-blue-700 text-sm mt-2 list-disc list-inside">
                            <li>Melihat dashboard karyawan secara langsung</li>
                            <li>Memverifikasi re-upload dari sisi karyawan</li>
                            <li>Membantu karyawan yang kesulitan mengisi form</li>
                            <li>Mengecek apakah link upload sudah benar</li>
                        </ul>
                        <p class="text-blue-700 text-sm mt-2">
                            <strong>Catatan:</strong> Setelah selesai, klik tombol <strong>"Kembali"</strong> yang berwarna kuning di pojok kanan atas.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Daftar Karyawan -->
            <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                <i class="fas fa-users text-blue-500 mr-2"></i> Pilih Karyawan
                <span class="ml-2 text-sm text-gray-500">({{ $karyawan->count() }} karyawan)</span>
            </h3>
            
            @if($karyawan->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($karyawan as $k)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition hover:border-blue-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $k->name }}</p>
                                        <p class="text-xs text-gray-500">
                                            <i class="fas fa-envelope mr-1"></i> {{ $k->email }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            <i class="fas fa-building mr-1"></i> {{ $k->cabang }}
                                        </p>
                                    </div>
                                </div>
                                <form action="{{ route('admin.impersonate.login', $k->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm transition flex items-center gap-1">
                                        <i class="fas fa-sign-in-alt"></i> Login
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-users-slash text-4xl mb-2 block"></i>
                    <p>Belum ada karyawan</p>
                    <a href="{{ route('admin.karyawan.create') }}" class="inline-block mt-2 text-blue-600 hover:underline">
                        <i class="fas fa-plus"></i> Tambah Karyawan
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection