<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Sistem - GudangSmart Inventory</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            DEFAULT: '#0066AE',
                            600: '#005591',
                            700: '#004474',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-full font-sans antialiased text-slate-800 bg-gradient-to-br from-[#4f8cfb] via-[#6875f5] to-[#a78bfa] flex flex-col justify-between p-4 sm:p-8 relative overflow-x-hidden">

    <!-- Top Bar Navigation (Sesuai Referensi Gambar Peppo: < Back & Logo) -->
    <div class="w-full max-w-6xl mx-auto flex items-center justify-between text-white/90 text-xs font-semibold py-2">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1.5 hover:text-white transition-colors bg-white/10 hover:bg-white/20 backdrop-blur-md px-3.5 py-1.5 rounded-full">
            <span>&larr;</span>
            <span>Dashboard</span>
        </a>
        <div class="flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full text-white font-bold tracking-wider uppercase text-[11px]">
            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <span>GUDANGSMART</span>
        </div>
    </div>

    <!-- Centered Card Container (Persis Referensi Gambar Peppo) -->
    <div class="w-full max-w-md mx-auto my-auto py-8">
        
        <!-- Flash Notification -->
        @if (session('success'))
            <div class="mb-4 p-4 rounded-2xl bg-white/95 backdrop-blur-md border border-emerald-200 text-emerald-800 text-xs font-semibold shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 rounded-2xl bg-white/95 backdrop-blur-md border border-rose-200 text-rose-800 text-xs font-semibold shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Floating White Card -->
        <div class="bg-white rounded-[28px] shadow-2xl shadow-indigo-950/25 p-8 sm:p-10 space-y-6 border border-white/60">
            
            <!-- Header Text -->
            <div class="text-center space-y-1.5">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-[#0066AE]/10 text-[#0066AE] font-black text-xl mb-1">
                    GS
                </div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Welcome Back!</h1>
                <p class="text-xs text-slate-500">We missed you! Please enter your details.</p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email</label>
                    <input type="email" 
                           name="email" 
                           id="email"
                           value="{{ old('email', 'manager@gudangsmart.com') }}"
                           required
                           autofocus
                           placeholder="Enter your Email" 
                           class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0066AE] focus:border-transparent transition-all @error('email') border-rose-400 bg-rose-50/50 @enderror">
                    @error('email')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" 
                               name="password" 
                               id="password"
                               value="password"
                               required
                               placeholder="Enter Password" 
                               class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0066AE] focus:border-transparent transition-all @error('password') border-rose-400 bg-rose-50/50 @enderror">
                    </div>
                    @error('password')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember & Role Note -->
                <div class="flex items-center justify-between text-xs text-slate-500 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-[#0066AE] focus:ring-[#0066AE] border-slate-300">
                        <span>Remember me</span>
                    </label>
                    <span class="text-slate-400 text-[11px]">Role-Based Auth (Soal 5)</span>
                </div>

                <!-- Sign in Button -->
                <button type="submit" 
                        class="w-full py-3 px-4 bg-[#0066AE] hover:bg-[#005591] text-white rounded-xl text-sm font-bold shadow-md shadow-blue-500/20 hover:shadow-lg transition-all active:scale-[0.99]">
                    Sign in
                </button>
            </form>

            <!-- Demo Account Switcher (One-Click) -->
            <div class="pt-5 border-t border-slate-100 space-y-3">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 text-center">Akun Demo Pengujian (UTS)</p>
                
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <button type="button" 
                            onclick="document.getElementById('email').value='manager@gudangsmart.com'; document.getElementById('password').value='password';"
                            class="p-2.5 rounded-xl border border-blue-100 bg-blue-50/60 hover:bg-blue-100/80 text-left transition-colors group">
                        <p class="font-bold text-[#0066AE] group-hover:underline">Manager Gudang</p>
                        <p class="text-[11px] text-slate-500 truncate">manager@gudangsmart.com</p>
                        <span class="text-[10px] text-blue-600 font-medium">Akses Penuh CRUD</span>
                    </button>

                    <button type="button" 
                            onclick="document.getElementById('email').value='staff@gudangsmart.com'; document.getElementById('password').value='password';"
                            class="p-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-left transition-colors group">
                        <p class="font-bold text-slate-800 group-hover:underline">Staff Gudang</p>
                        <p class="text-[11px] text-slate-500 truncate">staff@gudangsmart.com</p>
                        <span class="text-[10px] text-slate-500 font-medium">Katalog & Mutasi</span>
                    </button>
                </div>
                <p class="text-[11px] text-center text-slate-400">Kata sandi default: <strong>password</strong></p>
            </div>

        </div>

    </div>

    <!-- Bottom Footer -->
    <div class="w-full text-center text-xs text-white/75 py-2">
        &copy; {{ date('Y') }} GudangSmart • Sistem Inventory & Manufaktur
    </div>

</body>
</html>
