<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8f9fa]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - GudangSmart</title>

    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            DEFAULT: '#0066AE',
                            50: '#f0f7fc',
                            100: '#e0eff9',
                            200: '#b8daf3',
                            300: '#8ac0ec',
                            400: '#4fa1e2',
                            500: '#0066AE',
                            600: '#005591',
                            700: '#004474',
                            800: '#003357',
                            900: '#00233b',
                        },
                        primary: {
                            50: '#f0f7fc',
                            100: '#e0eff9',
                            500: '#0066AE',
                            600: '#005591',
                            700: '#004474',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
            color: #1e293b;
        }
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>
<body class="h-full antialiased" x-data="{ sidebarOpen: false }">

    <div class="min-h-full flex flex-col">
        <!-- 1. Header / Top Navbar (Minimalis, Rapi, Sesuai Gambar Referensi) -->
        <x-navbar />

        <div class="flex flex-1">
            <!-- 2. Sidebar Navigasi (Bersih, Terstruktur, Tanpa Elemen Menumpuk) -->
            <x-sidebar />

            <!-- Mobile Overlay -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false" 
                 class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30 lg:hidden" 
                 style="display: none;"></div>

            <!-- 3. Content Area Utama (Luas, Bernapas, Padding Konsisten) -->
            <main class="flex-1 lg:pl-64 flex flex-col min-w-0 transition-all duration-200">
                <div class="flex-1 p-6 sm:p-8 lg:p-10 max-w-7xl w-full mx-auto">
                    
                    <!-- Global Session Alerts -->
                    @if (session('success'))
                        <x-alert type="success" :message="session('success')" />
                    @endif

                    @if (session('error'))
                        <x-alert type="danger" :message="session('error')" />
                    @endif

                    @if (session('warning'))
                        <x-alert type="warning" :message="session('warning')" />
                    @endif

                    @if ($errors->any())
                        <x-alert type="danger">
                            <div class="font-bold mb-1">Perhatian pada formulir input:</div>
                            <ul class="list-disc list-inside space-y-0.5 text-xs">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </x-alert>
                    @endif

                    <!-- Content Injected via @section('content') -->
                    @yield('content')
                </div>

                <!-- 4. Footer Bersih & Sederhana -->
                <footer class="border-t border-slate-200 bg-white py-4 px-8 text-xs text-slate-400 mt-auto">
                    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
                        <div>
                            &copy; {{ date('Y') }} <strong class="text-slate-600">GudangSmart</strong> • Sistem Inventory & Manufaktur
                        </div>
                        <div class="flex items-center gap-2 text-slate-400">
                            <span>Versi 1.0</span>
                            <span>•</span>
                            <span class="text-emerald-600 font-medium flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Sistem Siap Digunakan
                            </span>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
