@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<div class="max-w-5xl mx-auto">
    
    <!-- Profile Banner -->
    <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-2xl shadow-lg p-6 mb-8 text-white">
        <div class="flex items-center gap-4 flex-wrap">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur">
                <i class="fas fa-user text-3xl text-white"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p class="text-green-100">
                    <i class="fas fa-building mr-1"></i> {{ Auth::user()->cabang }} 
                    <span class="mx-2">•</span>
                    <i class="fas fa-briefcase mr-1"></i> {{ Auth::user()->posisi }}
                </p>
            </div>
        </div>
    </div>
    
    @if($kontenBulanIni)
        <!-- Konten Wajib Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-3">
                <h2 class="text-white font-bold flex items-center">
                    <i class="fas fa-bullhorn mr-2"></i> Konten Wajib Bulan {{ date('F Y', strtotime($kontenBulanIni->month_year)) }}
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-500 text-sm">Platform</p>
                        <p class="font-medium capitalize flex items-center gap-2">
                            @if($kontenBulanIni->platform == 'facebook')
                                <i class="fab fa-facebook text-blue-600 text-xl"></i>
                            @elseif($kontenBulanIni->platform == 'instagram')
                                <i class="fab fa-instagram text-pink-600 text-xl"></i>
                            @else
                                <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                            @endif
                            {{ ucfirst($kontenBulanIni->platform) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Deadline</p>
                        <p class="font-medium {{ strtotime($kontenBulanIni->deadline_date) < time() ? 'text-red-600' : 'text-green-600' }}">
                            {{ date('d F Y', strtotime($kontenBulanIni->deadline_date)) }}
                            @if(strtotime($kontenBulanIni->deadline_date) < time())
                                <span class="text-xs ml-2 bg-red-100 px-2 py-0.5 rounded">Lewat</span>
                            @endif
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-500 text-sm">Link Konten Asli</p>
                        <a href="{{ $kontenBulanIni->original_link }}" target="_blank" class="text-blue-600 hover:underline break-all">
                            {{ $kontenBulanIni->original_link }}
                        </a>
                    </div>
                    @if($kontenBulanIni->description)
                        <div class="md:col-span-2">
                            <p class="text-gray-500 text-sm">Deskripsi</p>
                            <p class="text-gray-700">{{ $kontenBulanIni->description }}</p>
                        </div>
                    @endif
                </div>
                
                @if($sudahUpload)
                    <div class="bg-green-100 border-l-4 border-green-500 p-4 rounded-lg flex items-center gap-3">
                        <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                        <div>
                            <p class="font-semibold text-green-800">Anda Sudah Melakukan Re-Upload!</p>
                            <p class="text-green-700 text-sm">Terima kasih atas partisipasinya.</p>
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg mb-4">
                        <p class="text-yellow-800 text-sm mb-3">
                            <i class="fas fa-clock mr-1"></i> Anda belum melakukan re-upload untuk bulan ini.
                        </p>
                        <a href="{{ route('karyawan.reupload', $kontenBulanIni->id) }}" 
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                            <i class="fas fa-upload"></i> Laporkan Re-Upload
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="bg-yellow-50 rounded-xl shadow-md p-6 mb-8 border-l-4 border-yellow-500">
            <div class="flex items-center gap-3">
                <i class="fas fa-info-circle text-yellow-500 text-2xl"></i>
                <div>
                    <h3 class="font-bold text-yellow-800">Belum Ada Konten Wajib</h3>
                    <p class="text-yellow-700 text-sm">Admin belum menetapkan konten untuk bulan ini. Silakan hubungi admin.</p>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Riwayat Upload -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="font-bold text-gray-800 flex items-center">
                <i class="fas fa-history text-blue-500 mr-2"></i> Riwayat Re-Upload Saya
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bulan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platform</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Link Upload</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $riwayat = App\Models\ReuploadLog::where('user_id', Auth::id())->with('content')->orderBy('created_at', 'desc')->get();
                    @endphp
                    @forelse($riwayat as $log)
                        <tr>
                            <td class="px-6 py-4">{{ date('F Y', strtotime($log->content->month_year)) }}</td>
                            <td class="px-6 py-4 capitalize">{{ $log->content->platform }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ $log->uploaded_link }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                    Lihat Link
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ date('d-m-Y', strtotime($log->uploaded_at)) }}</td>
                            <td class="px-6 py-4">
                                @if($log->status == 'verified')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-check-circle mr-1"></i> Diverifikasi
                                    </span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-clock mr-1"></i> Menunggu
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                <i class="fas fa-inbox text-3xl mb-2 block"></i>
                                Belum ada riwayat upload
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection