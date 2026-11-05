@extends('layouts.app')

@section('title', 'Katalog Barang')

@section('content')
<div class="space-y-6">

    <!-- Top Header: Title & Action Buttons (Sesuai Finishing Halus Pharmly) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Barang</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola daftar produk, stok fisik gudang, dan supplier rekanan</p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.barang.trash') }}" class="px-3.5 py-2 bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 rounded-xl text-xs font-semibold shadow-xs transition-all flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span>Kotak Sampah</span>
            </a>
            <a href="{{ route('admin.barang.create') }}" class="px-4 py-2 bg-[#0066AE] hover:bg-[#005591] text-white rounded-xl text-xs font-semibold shadow-xs hover:shadow transition-all flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>+ Tambah Barang</span>
            </a>
        </div>
    </div>

    <!-- Search & Filter Bar (Gaya Toolbar Pharmly) -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('admin.barang.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <!-- Search Input with Search Icon -->
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" 
                       name="search" 
                       id="search"
                       value="{{ request('search') }}"
                       placeholder="Cari berdasarkan nama barang atau kode..." 
                       class="w-full pl-10 pr-4 py-2 bg-slate-50/70 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0066AE] focus:border-transparent transition-all">
            </div>

            <!-- Kategori Filter Dropdown -->
            <div class="w-full sm:w-60">
                <select name="kategori_id" 
                        onchange="this.form.submit()"
                        class="w-full px-3.5 py-2 bg-slate-50/70 border border-slate-200 rounded-xl text-xs text-slate-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0066AE]">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Button & Reset -->
            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-colors">
                Filter
            </button>

            @if (request()->hasAny(['search', 'kategori_id']))
                <a href="{{ route('admin.barang.index') }}" class="w-full sm:w-auto text-center px-3 py-2 text-xs text-rose-600 hover:text-rose-700 font-semibold">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>

    <!-- Data Table Card (Presisi Referensi Gambar Dwi Jaya dengan Finishing Halus Pharmly) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-xs font-semibold bg-slate-50/70 uppercase tracking-wider">
                        <th class="py-3.5 px-6 text-center w-16">No</th>
                        <th class="py-3.5 px-6">Kategori</th>
                        <th class="py-3.5 px-6">Merk / Supplier</th>
                        <th class="py-3.5 px-6">Barang</th>
                        <th class="py-3.5 px-6 text-center">Stock</th>
                        <th class="py-3.5 px-6 text-right">Harga Satuan</th>
                        <th class="py-3.5 px-6 text-center w-52">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($barang as $index => $item)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <!-- No -->
                            <td class="py-4 px-6 text-center text-slate-400 font-medium text-xs">
                                {{ $barang->firstItem() + $index }}
                            </td>

                            <!-- Kategori -->
                            <td class="py-4 px-6 text-slate-800 font-medium">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-medium">
                                    {{ $item->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>

                            <!-- Merk / Supplier -->
                            <td class="py-4 px-6 text-slate-700 font-medium text-xs">
                                {{ $item->supplier->nama_pt ?? '-' }}
                            </td>

                            <!-- Barang (Nama + Kode Produk) -->
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-900 block">{{ $item->nama_barang }}</span>
                                <span class="text-xs text-slate-400 font-mono">{{ $item->kode_barang }}</span>
                            </td>

                            <!-- Stock + Status Pill (Gaya Pharmly) -->
                            <td class="py-4 px-6 text-center">
                                <div class="font-extrabold text-slate-900 text-sm">{{ $item->stok }}</div>
                                @if ($item->stok > 50)
                                    <span class="inline-block mt-0.5 text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/60">
                                        In Stock
                                    </span>
                                @elseif ($item->stok > 0)
                                    <span class="inline-block mt-0.5 text-[10px] font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200/60">
                                        Low Stock
                                    </span>
                                @else
                                    <span class="inline-block mt-0.5 text-[10px] font-semibold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200/60">
                                        Out of Stock
                                    </span>
                                @endif
                            </td>

                            <!-- Harga Satuan -->
                            <td class="py-4 px-6 text-right font-bold text-slate-800">
                                Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                            </td>

                            <!-- Action Buttons: [ Edit ] [ View ] (Persis Referensi Gambar) -->
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit Button (Outline Button) -->
                                    <a href="{{ route('admin.barang.edit', $item->id) }}" 
                                       class="px-3.5 py-1 text-xs font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
                                        Edit
                                    </a>

                                    <!-- View Button (Solid Brand Button) -->
                                    <a href="{{ route('admin.barang.show', $item->id) }}" 
                                       class="px-3.5 py-1 text-xs font-semibold text-white bg-[#0066AE] hover:bg-[#005591] rounded-lg transition-colors shadow-xs">
                                        View
                                    </a>

                                    <!-- Hapus (Manager Only) -->
                                    @if (auth()->user()?->isManager())
                                        <form action="{{ route('admin.barang.destroy', $item->id) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Pindahkan barang \'{{ $item->nama_barang }}\' ke kotak sampah?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 rounded-md transition-colors" title="Hapus Barang">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                Tidak ada data barang yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (Gaya Pharmly: < [1] 2 3 ... >) -->
        <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
            <div class="text-slate-500">
                Menampilkan <span class="font-bold text-slate-800">{{ $barang->firstItem() ?? 0 }}</span> sampai <span class="font-bold text-slate-800">{{ $barang->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-800">{{ $barang->total() }}</span> barang
            </div>

            @if ($barang->hasPages())
                <nav class="flex items-center gap-1.5" aria-label="Pagination">
                    <!-- Previous Button -->
                    @if ($barang->onFirstPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed">
                            &lt;
                        </span>
                    @else
                        <a href="{{ $barang->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition-colors">
                            &lt;
                        </a>
                    @endif

                    <!-- Page Numbers -->
                    @foreach ($barang->getUrlRange(1, $barang->lastPage()) as $page => $url)
                        @if ($page == $barang->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#0066AE] text-white font-bold shadow-xs">
                                {{ $page }}
                            </span>
                        @elseif ($page == 1 || $page == $barang->lastPage() || abs($page - $barang->currentPage()) <= 2)
                            <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">
                                {{ $page }}
                            </a>
                        @elseif (abs($page - $barang->currentPage()) == 3)
                            <span class="w-8 h-8 flex items-center justify-center text-slate-400">...</span>
                        @endif
                    @endforeach

                    <!-- Next Button -->
                    @if ($barang->hasMorePages())
                        <a href="{{ $barang->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition-colors">
                            &gt;
                        </a>
                    @else
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed">
                            &gt;
                        </span>
                    @endif
                </nav>
            @endif
        </div>

    </div>

</div>
@endsection
