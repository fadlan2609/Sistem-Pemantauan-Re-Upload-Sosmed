<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BPRS ReUpload Monitor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-900 to-blue-600 min-h-screen flex items-center justify-center p-4">
    
    <div class="max-w-md w-full">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="bg-white/20 backdrop-blur-lg rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-chart-line text-white text-3xl"></i>
            </div>
            <h1 class="text-white text-3xl font-bold">BPRS Amanah Bangsa</h1>
            <p class="text-blue-100 mt-2">Sistem Pemantauan Re-Upload Sosial Media</p>
        </div>
        
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Masuk ke Akun</h2>
            
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                        <span class="text-red-700 text-sm">{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-envelope mr-2 text-gray-400"></i> Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           placeholder="admin@bprs.com">
                </div>
                
                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-lock mr-2 text-gray-400"></i> Password
                    </label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           placeholder="••••••••">
                </div>
                
                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                    </label>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i>
                    Masuk
                </button>
            </form>
            
            <!-- Demo Info -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-sm text-blue-800 font-medium mb-2">
                        <i class="fas fa-info-circle mr-1"></i> Akun Demo:
                    </p>
                    <p class="text-xs text-blue-700">Admin: admin@bprs.com / password123</p>
                    <p class="text-xs text-blue-700 mt-1">Karyawan: (sesuai yang dibuat admin)</p>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>