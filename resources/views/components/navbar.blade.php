@php
    $user = auth()->user();
    $dbConnection = config('database.default');
@endphp

<header class="bg-[#0066AE] border-b border-[#005591] sticky top-0 z-30 shadow-xs">
    <div class="px-6 lg:px-8 h-16 flex items-center justify-between">
        
        <!-- Left: Logo & Hamburger (Sesuai Referensi Gambar Dwi Jaya) -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-[#0066AE] font-black text-sm shadow-xs group-hover:scale-105 transition-transform">
                    <span class="tracking-tighter">dk</span>
                </div>
                <span class="text-lg font-bold text-white tracking-tight">Dwi Jaya</span>
            </a>

            <!-- Hamburger Button -->
            <button type="button" 
                    @click="sidebarOpen = !sidebarOpen" 
                    class="p-1.5 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition-colors focus:outline-none"
                    aria-label="Toggle Sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Right: Profile Area (Sesuai Referensi Gambar Dwi Jaya: Icon + 'Profile') -->
        <div class="flex items-center gap-3">
            @if ($user)
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button type="button" 
                            @click="open = !open" 
                            class="flex items-center gap-2 py-1.5 px-3 rounded-lg text-white hover:bg-white/10 transition-colors focus:outline-none"
                            aria-expanded="false">
                        <svg class="w-4 h-4 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm font-medium">Profile</span>
                        <svg class="w-3.5 h-3.5 text-white/70 transition-transform duration-150" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu Bersih & Rapi -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100" 
                         x-transition:enter-start="transform opacity-0 scale-95" 
                         x-transition:enter-end="transform opacity-100 scale-100" 
                         x-transition:leave="transition ease-in duration-75" 
                         x-transition:leave-start="transform opacity-100 scale-100" 
                         x-transition:leave-end="transform opacity-0 scale-95" 
                         class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-slate-200/80 py-2 z-50 divide-y divide-slate-100"
                         style="display: none;">
                        
                        <div class="px-4 py-3">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-[11px] font-semibold text-emerald-700 uppercase tracking-wider">Sistem Online ({{ strtoupper($dbConnection) }})</span>
                            </div>
                            <p class="text-sm font-bold text-slate-900 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
                            <span class="inline-block mt-2 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $user->isManager() ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                Role: {{ $user->role === 'manager' ? 'Manager Gudang' : 'Staff Gudang' }}
                            </span>
                        </div>

                        <div class="py-1 text-xs font-medium">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('admin.barang.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Katalog Barang
                            </a>
                        </div>

                        <div class="py-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar (Logout)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="px-4 py-1.5 text-xs font-semibold text-white bg-[#0d6efd] hover:bg-blue-700 rounded-lg transition-colors">
                    Login
                </a>
            @endif
        </div>

    </div>
</header>
