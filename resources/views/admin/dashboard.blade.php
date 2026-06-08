@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-lg p-6 mb-8 text-white">
        <div class="flex items-center justify-between flex-wrap">
            <div>
                <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p class="text-blue-100">Kelola pemantauan re-upload karyawan dengan mudah dan efisien.</p>
            </div>
            <div class="mt-4 lg:mt-0">
                <div class="bg-white/20 rounded-full px-4 py-2 backdrop-blur-sm">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    {{ now()->format('l, d F Y') }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Card 1: Total Karyawan -->
        <div class="bg-white rounded-xl shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Total Karyawan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalKaryawan }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-gray-400">
                <i class="fas fa-building mr-1"></i> {{ $totalCabang }} Cabang + Pusat
            </div>
        </div>
        
        <!-- Card 2: Karyawan Aktif -->
        <div class="bg-white rounded-xl shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Karyawan Aktif</p>
                    <p class="text-3xl font-bold text-green-600">{{ $karyawanAktif }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-gray-400">
                <i class="fas fa-chart-line mr-1"></i> Bulan Ini
            </div>
        </div>
        
        <!-- Card 3: Tidak Aktif -->
        <div class="bg-white rounded-xl shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Tidak Aktif</p>
                    <p class="text-3xl font-bold text-red-600">{{ $totalKaryawan - $karyawanAktif }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-xs text-gray-400">
                <i class="fas fa-clock mr-1"></i> Belum Re-Upload
            </div>
        </div>
        
        <!-- Card 4: Persentase Keaktifan -->
        <div class="bg-white rounded-xl shadow-md p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Keaktifan</p>
                    <p class="text-3xl font-bold text-purple-600">
                        {{ $totalKaryawan > 0 ? round(($karyawanAktif / $totalKaryawan) * 100) : 0 }}%
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-pie text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="w-full bg-gray-200 rounded-full h-1.5">
                    <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ $totalKaryawan > 0 ? ($karyawanAktif / $totalKaryawan) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Konten Bulan Ini -->
    @if(isset($bulanIni) && $bulanIni)
        <div class="bg-white rounded-xl shadow-md p-6 mb-8 border-l-4 border-blue-500">
            <div class="flex flex-wrap justify-between items-start">
                <div class="flex-1">
                    <div class="flex items-center mb-3 flex-wrap gap-2">
                        <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                        <h3 class="text-lg font-bold text-gray-800">Konten Wajib {{ date('F Y', strtotime($bulanIni->month_year)) }}</h3>
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full capitalize">
                            <i class="fas fa-globe mr-1"></i> {{ $bulanIni->platform }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Deadline</p>
                            <p class="font-medium {{ strtotime($bulanIni->deadline_date) < time() ? 'text-red-600' : 'text-green-600' }}">
                                {{ date('d F Y', strtotime($bulanIni->deadline_date)) }}
                                @if(strtotime($bulanIni->deadline_date) < time())
                                    <span class="text-xs ml-2 bg-red-100 px-2 py-0.5 rounded-full">Lewat</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500">Link Konten</p>
                            <a href="{{ $bulanIni->original_link }}" target="_blank" class="text-blue-600 hover:underline break-all">
                                {{ Str::limit($bulanIni->original_link, 50) }}
                                <i class="fas fa-external-link-alt text-xs ml-1"></i>
                            </a>
                        </div>
                        @if($bulanIni->description)
                            <div class="md:col-span-2">
                                <p class="text-gray-500">Deskripsi</p>
                                <p class="text-gray-700">{{ $bulanIni->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="mt-4 md:mt-0 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $karyawanAktif }}/{{ $totalKaryawan }}</div>
                    <div class="text-sm text-gray-500">Sudah Upload</div>
                    <div class="w-32 h-2 bg-gray-200 rounded-full mt-2 overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full" style="width: {{ $totalKaryawan > 0 ? ($karyawanAktif / $totalKaryawan) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-yellow-50 rounded-xl shadow-md p-6 mb-8 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between flex-wrap">
                <div>
                    <h3 class="font-bold text-yellow-800 mb-1">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Belum Ada Konten Wajib
                    </h3>
                    <p class="text-yellow-700 text-sm">Silakan buat konten untuk bulan ini melalui menu Kelola Konten.</p>
                </div>
                <a href="{{ route('admin.konten.create') }}" class="mt-3 md:mt-0 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-plus"></i> Buat Konten
                </a>
            </div>
        </div>
    @endif
    
    <!-- Menu Cepat -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-rocket text-blue-500 mr-2"></i> Menu Cepat
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('admin.karyawan') }}" class="bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl p-4 text-center transition group">
                <i class="fas fa-users text-3xl text-blue-600 mb-2 group-hover:scale-110 transition inline-block"></i>
                <div class="font-semibold text-blue-800 text-sm">Kelola Karyawan</div>
                <div class="text-xs text-blue-500 mt-1">Tambah/Edit/Hapus</div>
            </a>
            <a href="{{ route('admin.konten') }}" class="bg-gradient-to-br from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-xl p-4 text-center transition group">
                <i class="fas fa-file-alt text-3xl text-green-600 mb-2 group-hover:scale-110 transition inline-block"></i>
                <div class="font-semibold text-green-800 text-sm">Kelola Konten</div>
                <div class="text-xs text-green-500 mt-1">Buat konten wajib</div>
            </a>
            <a href="{{ route('admin.verifikasi') }}" class="bg-gradient-to-br from-yellow-50 to-yellow-100 hover:from-yellow-100 hover:to-yellow-200 rounded-xl p-4 text-center transition group">
                <i class="fas fa-check-double text-3xl text-yellow-600 mb-2 group-hover:scale-110 transition inline-block"></i>
                <div class="font-semibold text-yellow-800 text-sm">Verifikasi</div>
                <div class="text-xs text-yellow-500 mt-1">Validasi upload</div>
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="bg-gradient-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-xl p-4 text-center transition group">
                <i class="fas fa-chart-bar text-3xl text-purple-600 mb-2 group-hover:scale-110 transition inline-block"></i>
                <div class="font-semibold text-purple-800 text-sm">Laporan</div>
                <div class="text-xs text-purple-500 mt-1">PDF & Excel</div>
            </a>
            <a href="{{ route('admin.impersonate') }}" class="bg-gradient-to-br from-indigo-50 to-indigo-100 hover:from-indigo-100 hover:to-indigo-200 rounded-xl p-4 text-center transition group">
                <i class="fas fa-user-astronaut text-3xl text-indigo-600 mb-2 group-hover:scale-110 transition inline-block"></i>
                <div class="font-semibold text-indigo-800 text-sm">Login sebagai</div>
                <div class="text-xs text-indigo-500 mt-1">Akses akun karyawan</div>
            </a>
            <a href="{{ route('dashboard') }}" class="bg-gradient-to-br from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 rounded-xl p-4 text-center transition group">
                <i class="fas fa-home text-3xl text-gray-600 mb-2 group-hover:scale-110 transition inline-block"></i>
                <div class="font-semibold text-gray-800 text-sm">Dashboard</div>
                <div class="text-xs text-gray-500 mt-1">Ringkasan</div>
            </a>
        </div>
    </div>
    
    <!-- Tabel Ringkasan Per Cabang (6 Cabang + Pusat) -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-chart-simple text-blue-500 mr-2"></i> Keaktifan Per Cabang
            </h3>
            <a href="{{ route('admin.karyawan') }}" class="text-sm text-blue-600 hover:text-blue-800">
                Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cabang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Karyawan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktif</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tidak Aktif</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keaktifan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        // 6 Cabang + Pusat
                        $cabangList = [
                            'Pusat' => '🏢 Pusat (Kantor Pusat)',
                            'Pematangsiantar' => '📍 Pematangsiantar',
                            'Sidamanik' => '📍 Sidamanik',
                            'Perdagangan' => '📍 Perdagangan',
                            'Kisaran' => '📍 Kisaran',
                            'Stabat' => '📍 Stabat'
                        ];
                        $kontenId = isset($bulanIni) && $bulanIni ? $bulanIni->id : null;
                    @endphp
                    
                    @foreach($cabangList as $cabangValue => $cabangLabel)
                        @php
                            $jmlKaryawan = App\Models\User::where('role', 'karyawan')
                                ->where('cabang', $cabangValue)
                                ->count();
                            
                            $jmlAktif = 0;
                            if ($kontenId) {
                                $jmlAktif = App\Models\User::where('role', 'karyawan')
                                    ->where('cabang', $cabangValue)
                                    ->whereHas('reuploadLogs', function($q) use ($kontenId) {
                                        $q->where('content_id', $kontenId)->where('status', 'verified');
                                    })
                                    ->count();
                            }
                            
                            $jmlTidakAktif = $jmlKaryawan - $jmlAktif;
                            $persen = $jmlKaryawan > 0 ? round(($jmlAktif / $jmlKaryawan) * 100) : 0;
                            
                            if ($persen >= 80) {
                                $barColor = 'bg-green-500';
                                $badgeColor = 'bg-green-100 text-green-700';
                            } elseif ($persen >= 50) {
                                $barColor = 'bg-yellow-500';
                                $badgeColor = 'bg-yellow-100 text-yellow-700';
                            } else {
                                $barColor = 'bg-red-500';
                                $badgeColor = 'bg-red-100 text-red-700';
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                {{ $cabangLabel }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                <span class="font-semibold">{{ $jmlKaryawan }}</span> orang
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-green-600 font-semibold">{{ $jmlAktif }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-red-600">{{ $jmlTidakAktif }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-24 bg-gray-200 rounded-full h-2">
                                        <div class="{{ $barColor }} h-2 rounded-full" style="width: {{ $persen }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium {{ $badgeColor }} px-2 py-0.5 rounded-full">
                                        {{ $persen }}%
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                @if(isset($kontenId) && $kontenId)
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Status berdasarkan konten bulan {{ date('F Y', strtotime($bulanIni->month_year)) }}
                                (Platform: {{ ucfirst($bulanIni->platform) }})
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
    
    <!-- Footer Informasi -->
    <div class="mt-6 text-center text-xs text-gray-400">
        <p>BPRS Amanah Bangsa - Sistem Pemantauan Re-Upload Sosial Media v1.0</p>
        <p class="mt-1">© {{ date('Y') }} - Kantor Pusat Pematangsiantar</p>
    </div>
</div>
@endsection