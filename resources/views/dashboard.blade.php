@extends('layouts.app')

@section('title', 'Display - Dashboard Inventory')

@section('content')
<div class="space-y-8">

    <!-- Header Section (Sesuai Layout Pharmly) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Display</h1>
            <p class="text-xs text-slate-500 mt-1">Let's check your warehouse inventory performance today</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.mutasi.create') }}" class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-xs transition-all">
                + Input Mutasi
            </a>
            <a href="{{ route('admin.barang.create') }}" class="px-4 py-2 bg-[#0066AE] hover:bg-[#005591] text-white rounded-xl text-xs font-semibold shadow-xs hover:shadow transition-all">
                + Tambah Barang
            </a>
        </div>
    </div>

    <!-- 3 Buah Card Ringkasan Utama (Wajib Soal 2.3) - Desain Kartu Halus Modern Pharmly -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        
        <!-- Card 1: Total Supplier Terdaftar -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50/80 border border-blue-100 flex items-center justify-center text-[#0066AE] group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="space-y-0.5">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Supplier Terdaftar</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ number_format($totalSupplier) }}</div>
                    <a href="{{ route('admin.suppliers.index') }}" class="text-xs text-[#0066AE] hover:underline font-medium inline-block">
                        Kelola Supplier &rarr;
                    </a>
                </div>
            </div>
            <span class="text-slate-300 text-lg">&vellip;</span>
        </div>

        <!-- Card 2: Total Jenis Barang (SKU) -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50/80 border border-indigo-100 flex items-center justify-center text-indigo-600 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="space-y-0.5">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Jenis Barang (SKU)</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ number_format($totalJenisBarang) }}</div>
                    <a href="{{ route('admin.barang.index') }}" class="text-xs text-[#0066AE] hover:underline font-medium inline-block">
                        Lihat Katalog &rarr;
                    </a>
                </div>
            </div>
            <span class="text-slate-300 text-lg">&vellip;</span>
        </div>

        <!-- Card 3: Total Stok Fisik Gudang -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50/80 border border-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="space-y-0.5">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Stok Fisik Gudang (Unit)</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                        {{ number_format($totalStokFisikGudang) }} <span class="text-xs font-normal text-slate-400">Unit</span>
                    </div>
                    <a href="{{ route('admin.mutasi.index') }}" class="text-xs text-emerald-600 hover:underline font-medium inline-block">
                        Riwayat Mutasi &rarr;
                    </a>
                </div>
            </div>
            <span class="text-slate-300 text-lg">&vellip;</span>
        </div>

    </div>

    <!-- Secondary Status Row (Sesuai Referensi Pharmly: Low Stock, Out of Stock, Kategori) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <!-- Low Stock Items -->
        <div class="bg-white rounded-xl p-4 border border-slate-200/70 shadow-xs flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Stok Menipis (&le; 50)</p>
                    <p class="text-lg font-bold text-slate-900">{{ $totalLowStock }} Barang</p>
                </div>
            </div>
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200/60">Perlu Restock</span>
        </div>

        <!-- Out of Stock -->
        <div class="bg-white rounded-xl p-4 border border-slate-200/70 shadow-xs flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Stok Habis (0 Unit)</p>
                    <p class="text-lg font-bold text-slate-900">{{ $totalOutOfStock }} Barang</p>
                </div>
            </div>
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200/60">Kosong</span>
        </div>

        <!-- Total Kategori -->
        <div class="bg-white rounded-xl p-4 border border-slate-200/70 shadow-xs flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-[#0066AE] flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Kategori Barang</p>
                    <p class="text-lg font-bold text-slate-900">{{ $totalKategori }} Kategori</p>
                </div>
            </div>
            <a href="{{ route('admin.kategori.index') }}" class="text-xs text-[#0066AE] hover:underline font-semibold">Kelola &rarr;</a>
        </div>

    </div>

    <!-- Riwayat Transaksi Mutasi Terbaru (Gaya Kartu & Tabel Pharmly) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4.5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Riwayat Mutasi Stok Terbaru</h2>
                <p class="text-xs text-slate-400 mt-0.5">Transaksi penerimaan dan pengeluaran barang terkini</p>
            </div>
            <a href="{{ route('admin.mutasi.index') }}" class="text-xs font-semibold text-[#0066AE] hover:underline">
                Lihat Semua Mutasi &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-xs font-semibold bg-slate-50/70 uppercase tracking-wider">
                        <th class="py-3.5 px-6">Waktu</th>
                        <th class="py-3.5 px-6">Barang</th>
                        <th class="py-3.5 px-6 text-center">Jenis Mutasi</th>
                        <th class="py-3.5 px-6 text-right">Jumlah</th>
                        <th class="py-3.5 px-6">Petugas</th>
                        <th class="py-3.5 px-6">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($mutasiTerbaru as $mut)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-3.5 px-6 text-xs text-slate-500 whitespace-nowrap">
                                {{ $mut->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-3.5 px-6 font-medium text-slate-900">
                                {{ $mut->barang->nama_barang ?? '-' }}
                                <span class="text-[11px] text-slate-400 block font-mono">{{ $mut->barang->kode_barang ?? '' }}</span>
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                @if ($mut->jenis === 'masuk')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Masuk
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-right font-bold text-slate-900">
                                {{ number_format($mut->jumlah) }} Unit
                            </td>
                            <td class="py-3.5 px-6 text-xs text-slate-600">
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 font-medium">{{ $mut->user->name ?? 'System' }}</span>
                            </td>
                            <td class="py-3.5 px-6 text-xs text-slate-400 max-w-xs truncate">
                                {{ $mut->keterangan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400">
                                Belum ada catatan transaksi mutasi stok.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
