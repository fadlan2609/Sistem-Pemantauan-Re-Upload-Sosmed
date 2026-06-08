@extends('layouts.app')

@section('title', 'Tambah Karyawan')

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
        <span class="text-gray-700">Tambah Karyawan</span>
    </div>
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex justify-between items-center">
            <h2 class="text-white font-bold flex items-center">
                <i class="fas fa-user-plus mr-2"></i> Tambah Karyawan Baru
            </h2>
            <a href="{{ route('admin.karyawan') }}" class="bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-lg transition text-sm">
                <i class="fas fa-times"></i> Tutup
            </a>
        </div>
        
        <div class="p-6">
            <form method="POST" action="{{ route('admin.karyawan.store') }}" id="karyawanForm">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama Lengkap (dengan event onkeyup untuk generate email) -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Contoh: Ahmad Fauzi"
                               onkeyup="generateEmail()">
                        <p class="text-xs text-gray-500 mt-1">Nama lengkap karyawan</p>
                    </div>
                    
                    <!-- Email (auto-generated, bisa diedit manual jika perlu) -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
                               placeholder="Email akan otomatis terisi">
                        <p class="text-xs text-gray-500 mt-1">Email otomatis dari nama lengkap (bisa diedit)</p>
                    </div>
                    
                    <!-- Password (auto-generate) -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-2">
                            <input type="password" name="password" id="password" required 
                                   class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Password">
                            <button type="button" onclick="generatePassword()" 
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg transition text-sm">
                                <i class="fas fa-sync-alt"></i> Generate
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter, atau klik Generate untuk buat otomatis</p>
                    </div>
                    
                    <!-- Cabang -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            Cabang <span class="text-red-500">*</span>
                        </label>
                        <select name="cabang" required 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Cabang</option>
                            <option value="Pusat">🏢 Pusat (Kantor Pusat)</option>
                            <option value="Pematangsiantar">📍 Pematangsiantar</option>
                            <option value="Sidamanik">📍 Sidamanik</option>
                            <option value="Perdagangan">📍 Perdagangan</option>
                            <option value="Kisaran">📍 Kisaran</option>
                            <option value="Stabat">📍 Stabat</option>
                        </select>
                    </div>
                    
                    <!-- Facebook URL -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            <i class="fab fa-facebook text-blue-600 mr-1"></i> Facebook URL
                        </label>
                        <input type="url" name="fb_url" placeholder="https://facebook.com/username" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Isi jika ada</p>
                    </div>
                    
                    <!-- Instagram URL -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            <i class="fab fa-instagram text-pink-600 mr-1"></i> Instagram URL
                        </label>
                        <input type="url" name="ig_url" placeholder="https://instagram.com/username" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Isi jika ada</p>
                    </div>
                    
                    <!-- WhatsApp Number -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">
                            <i class="fab fa-whatsapp text-green-600 mr-1"></i> WhatsApp Number
                        </label>
                        <input type="text" name="wa_number" placeholder="08123456789" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Isi nomor WhatsApp aktif</p>
                    </div>
                </div>
                
                <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.karyawan') }}" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2.5 rounded-lg transition text-center">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Karyawan
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Informasi Tambahan -->
    <div class="mt-4 p-3 bg-blue-50 rounded-lg">
        <p class="text-xs text-blue-700">
            <i class="fas fa-info-circle mr-1"></i> 
            <strong>Fitur Otomatis:</strong> Email akan otomatis dibuat dari nama lengkap dengan format <strong>namalengkap@bprs.com</strong> (huruf kecil, tanpa spasi, tanpa simbol).
            Password bisa di-generate otomatis atau diisi manual.
        </p>
    </div>
</div>

@push('scripts')
<script>
    // Fungsi untuk generate email dari nama lengkap
    function generateEmail() {
        let name = document.getElementById('name').value;
        
        if (name) {
            // Ubah ke huruf kecil
            let emailName = name.toLowerCase();
            
            // Hapus semua yang bukan huruf, angka, atau spasi
            emailName = emailName.replace(/[^a-z0-9\s]/g, '');
            
            // Ganti spasi dengan titik
            emailName = emailName.replace(/\s+/g, '.');
            
            // Hapus titik di awal dan akhir
            emailName = emailName.replace(/^\.+|\.+$/g, '');
            
            // Hapus multiple titik menjadi satu titik
            emailName = emailName.replace(/\.+/g, '.');
            
            // Gabungkan dengan domain
            let email = emailName + '@bprs.com';
            
            // Isi field email
            document.getElementById('email').value = email;
        } else {
            document.getElementById('email').value = '';
        }
    }
    
    // Fungsi untuk generate password acak
    function generatePassword() {
        // Karakter yang diizinkan untuk password
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%';
        let password = '';
        
        // Generate password dengan panjang 10 karakter
        for (let i = 0; i < 10; i++) {
            const randomIndex = Math.floor(Math.random() * chars.length);
            password += chars[randomIndex];
        }
        
        // Isi field password
        document.getElementById('password').value = password;
    }
    
    // Optional: Generate email juga saat pertama kali load (jika ada nama default)
    document.addEventListener('DOMContentLoaded', function() {
        // Generate password default saat halaman load
        generatePassword();
        
        // Jika field name sudah terisi, generate email
        if (document.getElementById('name').value) {
            generateEmail();
        }
    });
</script>
@endpush
@endsection