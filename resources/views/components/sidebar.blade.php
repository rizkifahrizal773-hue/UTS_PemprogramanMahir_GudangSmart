@php
    $isBarangActive = request()->routeIs('admin.barang.*');
    $isSupplierActive = request()->routeIs('admin.suppliers.*');
    $isMutasiActive = request()->routeIs('admin.mutasi.*');
    $isKategoriActive = request()->routeIs('admin.kategori.*');
    $isDashboardActive = request()->routeIs('admin.dashboard');
@endphp

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed inset-y-0 left-0 z-40 w-64 bg-[#0066AE] border-r border-[#005591] text-white transition-transform duration-200 ease-in-out flex flex-col justify-between overflow-y-auto shadow-md">

    <div>
        <!-- Mobile Top Header -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-white/10 bg-[#005591] lg:hidden">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white flex items-center justify-center text-[#0066AE] font-black text-xs shadow-xs">
                    dk
                </div>
                <span class="font-bold text-white text-base">Dwi Jaya</span>
            </div>
            <button @click="sidebarOpen = false" class="text-white/80 hover:text-white p-1 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation Menu List (Persis Tata Letak Gambar Referensi dengan Tema Brand #0066AE) -->
        <nav class="py-6 px-4 space-y-1.5 text-sm font-medium">

            <!-- 1. Display / Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ $isDashboardActive ? 'bg-white text-[#0066AE] font-bold shadow-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                <svg class="w-4 h-4 {{ $isDashboardActive ? 'text-[#0066AE]' : 'text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Display</span>
            </a>

            <!-- 2. Barang (Dropdown Sesuai Referensi Gambar) -->
            <div x-data="{ open: {{ $isBarangActive ? 'true' : 'true' }} }" class="space-y-1">
                <button type="button"
                        @click="open = !open"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ $isBarangActive ? 'bg-white/15 text-white font-bold' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ $isBarangActive ? 'text-white' : 'text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span>Barang</span>
                    </div>
                    <svg class="w-3.5 h-3.5 transition-transform duration-150 {{ $isBarangActive ? 'text-white' : 'text-blue-200' }}" :class="{ 'rotate-180': !open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Sub-items Barang -->
                <div x-show="open" class="pl-8 pr-2 space-y-1 pt-0.5">
                    <a href="{{ route('admin.barang.create') }}"
                       class="block px-3 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.barang.create') ? 'bg-white text-[#0066AE] font-bold shadow-xs' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                        • Tambah Barang
                    </a>
                    <a href="{{ route('admin.barang.index') }}"
                       class="block px-3 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.barang.index') ? 'bg-white text-[#0066AE] font-bold shadow-xs' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                        • Daftar Barang
                    </a>
                    <a href="{{ route('admin.barang.trash') }}"
                       class="block px-3 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.barang.trash') ? 'bg-rose-500 text-white font-bold shadow-xs' : 'text-rose-200 hover:text-white hover:bg-white/10' }}">
                        • Kotak Sampah
                    </a>
                </div>
            </div>

            <!-- 3. Mutasi Stok / Order -->
            <div x-data="{ open: {{ $isMutasiActive ? 'true' : 'false' }} }" class="space-y-1">
                <button type="button"
                        @click="open = !open"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ $isMutasiActive ? 'bg-white/15 text-white font-bold' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ $isMutasiActive ? 'text-white' : 'text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Order / Mutasi</span>
                    </div>
                    <svg class="w-3.5 h-3.5 transition-transform duration-150 {{ $isMutasiActive ? 'text-white' : 'text-blue-200' }}" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="pl-8 pr-2 space-y-1 pt-0.5">
                    <a href="{{ route('admin.mutasi.create') }}"
                       class="block px-3 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.mutasi.create') ? 'bg-white text-[#0066AE] font-bold shadow-xs' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                        • Input Transaksi
                    </a>
                    <a href="{{ route('admin.mutasi.index') }}"
                       class="block px-3 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.mutasi.index') ? 'bg-white text-[#0066AE] font-bold shadow-xs' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                        • Riwayat Mutasi
                    </a>
                </div>
            </div>

            <!-- 4. Supplier -->
            <div x-data="{ open: {{ $isSupplierActive ? 'true' : 'false' }} }" class="space-y-1">
                <button type="button"
                        @click="open = !open"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ $isSupplierActive ? 'bg-white/15 text-white font-bold' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ $isSupplierActive ? 'text-white' : 'text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Supplier</span>
                    </div>
                    <svg class="w-3.5 h-3.5 transition-transform duration-150 {{ $isSupplierActive ? 'text-white' : 'text-blue-200' }}" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="pl-8 pr-2 space-y-1 pt-0.5">
                    <a href="{{ route('admin.suppliers.index') }}"
                       class="block px-3 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.suppliers.index') ? 'bg-white text-[#0066AE] font-bold shadow-xs' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                        • Daftar Supplier
                    </a>
                    @if (auth()->user()?->isManager())
                        <a href="{{ route('admin.suppliers.create') }}"
                           class="block px-3 py-1.5 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.suppliers.create') ? 'bg-white text-[#0066AE] font-bold shadow-xs' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                            • Tambah Supplier
                        </a>
                    @endif
                </div>
            </div>

            <!-- 5. Kategori Barang -->
            <a href="{{ route('admin.kategori.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ $isKategoriActive ? 'bg-white text-[#0066AE] font-bold shadow-sm' : 'text-blue-100 hover:text-white hover:bg-white/10' }}">
                <svg class="w-4 h-4 {{ $isKategoriActive ? 'text-[#0066AE]' : 'text-blue-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span>Kategori Barang</span>
            </a>

            <!-- 6. User Info -->
            <div class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-blue-100 hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <div class="flex-1 flex items-center justify-between">
                    <span>User</span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-white/20 text-white border border-white/20">
                        {{ auth()->user()?->role ?? 'Guest' }}
                    </span>
                </div>
            </div>

        </nav>
    </div>

    <!-- Bottom: Sign out button minimalis -->
    <div class="p-4 border-t border-white/10">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-blue-100 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Keluar dari Akun</span>
            </button>
        </form>
    </div>

</aside>
