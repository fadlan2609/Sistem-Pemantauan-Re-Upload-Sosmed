<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BPRS Amanah Bangsa - ReUpload Monitor')</title>
    
    <!-- Tailwind CSS + Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a5f',
                        secondary: '#2d6a4f',
                        accent: '#f4a261',
                    }
                }
            }
        }
    </script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #f3f4f6;
        }
        
        .sidebar-transition {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert-animation {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    
    <!-- Top Navigation Bar -->
    <nav class="bg-gradient-to-r from-primary to-blue-800 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <i class="fas fa-chart-line text-white text-2xl mr-3"></i>
                        <h1 class="text-white font-bold text-xl hidden sm:block">BPRS Amanah Bangsa</h1>
                        <span class="text-white text-sm ml-2 hidden md:block">| Re-Upload Monitor</span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Impersonate Mode Indicator -->
                    @if(session()->has('impersonate_as'))
                        <div class="bg-yellow-500 text-white px-3 py-1.5 rounded-full text-xs flex items-center gap-2 shadow-md">
                            <i class="fas fa-user-astronaut"></i>
                            <span class="font-medium">Mode: Login sebagai Karyawan</span>
                            <a href="{{ route('admin.impersonate.logout') }}" class="ml-1 text-white hover:text-yellow-200 transition flex items-center gap-1" onclick="return confirm('Kembali ke akun admin?')">
                                <i class="fas fa-sign-out-alt"></i> Kembali
                            </a>
                        </div>
                    @endif
                    
                    <!-- User Info -->
                    <div class="flex items-center space-x-3">
                        <div class="hidden md:block text-right">
                            <p class="text-white text-sm font-medium">{{ Auth::user()->name }}</p>
                            <p class="text-blue-200 text-xs capitalize">{{ Auth::user()->role }} | {{ Auth::user()->cabang }}</p>
                        </div>
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md">
                            <i class="fas fa-user text-primary text-sm"></i>
                        </div>
                    </div>
                    
                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto mb-4 alert-animation">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="max-w-7xl mx-auto mb-4 alert-animation">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3 text-xl"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif
        
        @if(session('warning'))
            <div class="max-w-7xl mx-auto mb-4 alert-animation">
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mr-3 text-xl"></i>
                        <span>{{ session('warning') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-yellow-700 hover:text-yellow-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif
        
        @if(session('info'))
            <div class="max-w-7xl mx-auto mb-4 alert-animation">
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-3 text-xl"></i>
                        <span>{{ session('info') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-blue-700 hover:text-blue-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif
        
        <!-- Yield Content -->
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-500 text-sm">
                <i class="fas fa-building mr-1"></i> BPRS Amanah Bangsa - Sistem Pemantauan Re-Upload Sosial Media
            </p>
            <p class="text-gray-400 text-xs mt-1">
                © {{ date('Y') }} Kantor Pusat Pematangsiantar | Version 1.0
            </p>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>