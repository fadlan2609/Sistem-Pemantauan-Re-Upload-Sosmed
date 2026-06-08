@extends('layouts.app')

@section('title', 'Verifikasi Re-Upload')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700">Verifikasi Re-Upload</span>
    </div>
    
    <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-check-double text-blue-500 mr-3"></i> Verifikasi Re-Upload Karyawan
        </h1>
        <div class="flex gap-3">
            <a href="{{ route('admin.impersonate') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-user-astronaut"></i> Login sebagai Karyawan
            </a>
            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    
    <!-- Tabel Pending Verifikasi -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="px-6 py-4 bg-yellow-50 border-b border-yellow-200">
            <h2 class="font-bold text-yellow-800 flex items-center">
                <i class="fas fa-clock mr-2"></i> Menunggu Verifikasi ({{ $pendingLogs->count() }})
            </h2>
        </div>
        
        @if($pendingLogs->count() > 0)
            <!-- 🔥 FORM BATCH - HARUS METHOD POST 🔥 -->
            <form method="POST" action="{{ route('admin.verifikasi.batch') }}" id="batchForm">
                @csrf
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-center w-10">
                                    <input type="checkbox" id="selectAll" class="rounded border-gray-300">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Karyawan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cabang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bulan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platform</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Link Upload</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($pendingLogs as $log)
                            <tr>
                                <td class="px-4 py-4 text-center">
                                    <input type="checkbox" name="log_ids[]" value="{{ $log->id }}" class="checkbox-item rounded border-gray-300">
                                </td>
                                <td class="px-6 py-4 font-medium">{{ $log->user->name }}</td>
                                <td class="px-6 py-4">{{ $log->user->cabang }}</td>
                                <td class="px-6 py-4">{{ date('F Y', strtotime($log->content->month_year)) }}</td>
                                <td class="px-6 py-4 capitalize">{{ $log->content->platform }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ $log->uploaded_link }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                        <i class="fas fa-external-link-alt mr-1"></i> Lihat
                                    </a>
                                </td>
                                <td class="px-6 py-4">{{ date('d-m-Y', strtotime($log->uploaded_at)) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('admin.verifikasi.verify', $log->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm transition" onclick="return confirm('Verifikasi upload dari {{ $log->user->name }}?')">
                                                <i class="fas fa-check"></i> Valid
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.verifikasi.reject', $log->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm transition" onclick="return confirm('Tolak upload dari {{ $log->user->name }}? Data akan dihapus.')">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                    <!-- 🔥 TOMBOL INI YAKAN MEMICU POST REQUEST 🔥 -->
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                        <i class="fas fa-check-double"></i> Verifikasi Terpilih
                    </button>
                    <span class="text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i> Centang multiple untuk verifikasi massal
                    </span>
                </div>
            </form>
        @else
            <div class="p-8 text-center text-gray-400">
                <i class="fas fa-check-circle text-4xl mb-3 block text-green-400"></i>
                <p>Tidak ada pengajuan verifikasi</p>
                <p class="text-sm mt-1">Semua karyawan sudah diverifikasi</p>
            </div>
        @endif
    </div>
    
    <!-- Riwayat Verifikasi -->
    @if(isset($verifiedLogs) && $verifiedLogs->count() > 0)
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-green-50 border-b border-green-200">
            <h2 class="font-bold text-green-800 flex items-center">
                <i class="fas fa-history mr-2"></i> Riwayat Verifikasi (Terakhir)
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Karyawan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cabang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bulan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Link Upload</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diverifikasi oleh</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($verifiedLogs as $log)
                    <tr>
                        <td class="px-6 py-4">{{ $log->user->name }}</td>
                        <td class="px-6 py-4">{{ $log->user->cabang }}</td>
                        <td class="px-6 py-4">{{ date('F Y', strtotime($log->content->month_year)) }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ $log->uploaded_link }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                Lihat Link
                            </a>
                        </td>
                        <td class="px-6 py-4">{{ $log->verifier->name ?? 'Admin' }}</td>
                        <td class="px-6 py-4">{{ $log->updated_at->format('d-m-Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Select All checkbox
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function(e) {
            document.querySelectorAll('.checkbox-item').forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
        });
    }
    
    // Optional: Submit form via AJAX
    // document.getElementById('batchForm')?.addEventListener('submit', function(e) {
    //     e.preventDefault();
    //     // AJAX submission code here
    // });
</script>
@endpush
@endsection