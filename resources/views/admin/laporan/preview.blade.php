@extends('layouts.app')

@section('title', 'Preview Laporan')

@section('content')
<div class="max-w-full mx-auto">
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4 flex justify-between items-center flex-wrap gap-3">
            <div>
                <h2 class="text-white font-bold text-xl">📊 Laporan Re-Upload</h2>
                <p class="text-purple-100 text-sm">{{ $bulan }} | {{ $cabang }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.laporan.pdf') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
                <a href="{{ route('admin.laporan.excel') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Summary Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg text-center">
                    <p class="text-gray-500 text-sm">Total Karyawan</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $total_karyawan }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg text-center">
                    <p class="text-gray-500 text-sm">Aktif</p>
                    <p class="text-2xl font-bold text-green-700">{{ $total_aktif }}</p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg text-center">
                    <p class="text-gray-500 text-sm">Tidak Aktif</p>
                    <p class="text-2xl font-bold text-red-700">{{ $total_tidak_aktif }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg text-center">
                    <p class="text-gray-500 text-sm">Keaktifan</p>
                    <p class="text-2xl font-bold text-purple-700">{{ $persentase_keaktifan }}%</p>
                </div>
            </div>
            
            <!-- Info Konten -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="font-semibold mb-2 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i> Informasi Konten
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                    <div><span class="text-gray-500">Platform:</span> <strong class="capitalize">{{ $konten->platform }}</strong></div>
                    <div><span class="text-gray-500">Deadline:</span> {{ date('d-m-Y', strtotime($konten->deadline_date)) }}</div>
                    <div><span class="text-gray-500">Link Konten:</span> <a href="{{ $konten->original_link }}" target="_blank" class="text-blue-600 hover:underline">Buka</a></div>
                </div>
            </div>
            
            <!-- Tabel Detail -->
            <div class="overflow-x-auto">
                <table class="w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-3 py-2 text-left text-sm">No</th>
                            <th class="border px-3 py-2 text-left text-sm">Nama</th>
                            <th class="border px-3 py-2 text-left text-sm">Cabang</th>
                            <th class="border px-3 py-2 text-left text-sm">Posisi</th>
                            <th class="border px-3 py-2 text-left text-sm">Tanggal Upload</th>
                            <th class="border px-3 py-2 text-left text-sm">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporan as $index => $item)
                            <tr>
                                <td class="border px-3 py-2">{{ $index + 1 }}</td>
                                <td class="border px-3 py-2">{{ $item['nama'] }}</td>
                                <td class="border px-3 py-2">{{ $item['cabang'] }}</td>
                                <td class="border px-3 py-2">{{ $item['posisi'] }}</td>
                                <td class="border px-3 py-2">{{ $item['tanggal_upload'] }}</td>
                                <td class="border px-3 py-2">
                                    @if($item['status'] == 'Aktif')
                                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs">✅ Aktif</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs">❌ Tidak Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 text-right text-xs text-gray-400">
                Dicetak: {{ $tanggal_cetak }}
            </div>
        </div>
    </div>
</div>
@endsection