@extends('layouts.app')

@section('title', 'Tambah Konten')

@section('content')
<div class="max-w-2xl mx-auto">
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
            <h2 class="text-white font-bold flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Tambah Konten Wajib
            </h2>
        </div>
        
        <div class="p-6">
            <form method="POST" action="{{ route('admin.konten.store') }}">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Bulan <span class="text-red-500">*</span></label>
                        <input type="month" name="month_year" required value="{{ date('Y-m') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Deadline <span class="text-red-500">*</span></label>
                        <input type="date" name="deadline_date" required value="{{ date('Y-m-25') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Platform <span class="text-red-500">*</span></label>
                        <select name="platform" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="facebook">📘 Facebook (Utama)</option>
                            <option value="instagram">📷 Instagram</option>
                            <option value="whatsapp">💬 WhatsApp</option>
                        </select>
                    </div>
                    
                    <div class="mb-4 md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">Link Konten Asli <span class="text-red-500">*</span></label>
                        <input type="url" name="original_link" required placeholder="https://..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div class="mb-4 md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">Deskripsi (Opsional)</label>
                        <textarea name="description" rows="3" placeholder="Deskripsi singkat tentang konten..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>
                </div>
                
                <div class="flex gap-3 mt-4">
                    <a href="{{ route('admin.konten') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2.5 rounded-lg transition text-center">Batal</a>
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection