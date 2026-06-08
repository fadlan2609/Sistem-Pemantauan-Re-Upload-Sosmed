@extends('layouts.app')

@section('title', 'Edit Konten')

@section('content')
<div class="max-w-2xl mx-auto">
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-600 to-orange-600 px-6 py-4">
            <h2 class="text-white font-bold flex items-center">
                <i class="fas fa-edit mr-2"></i> Edit Konten Wajib
            </h2>
        </div>
        
        <div class="p-6">
            <form method="POST" action="{{ route('admin.konten.update', $konten->id) }}">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Bulan</label>
                        <input type="month" name="month_year" required value="{{ $konten->month_year->format('Y-m') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Deadline</label>
                        <input type="date" name="deadline_date" required value="{{ $konten->deadline_date->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Platform</label>
                        <select name="platform" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="facebook" {{ $konten->platform == 'facebook' ? 'selected' : '' }}>📘 Facebook</option>
                            <option value="instagram" {{ $konten->platform == 'instagram' ? 'selected' : '' }}>📷 Instagram</option>
                            <option value="whatsapp" {{ $konten->platform == 'whatsapp' ? 'selected' : '' }}>💬 WhatsApp</option>
                        </select>
                    </div>
                    
                    <div class="mb-4 md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">Link Konten Asli</label>
                        <input type="url" name="original_link" required value="{{ $konten->original_link }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    
                    <div class="mb-4 md:col-span-2">
                        <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                        <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-500">{{ $konten->description }}</textarea>
                    </div>
                </div>
                
                <div class="flex gap-3 mt-4">
                    <a href="{{ route('admin.konten') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2.5 rounded-lg transition text-center">Batal</a>
                    <button type="submit" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2.5 rounded-lg transition">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection