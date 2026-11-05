@extends('layouts.app')

@section('title', 'Detail Barang: ' . $barang->nama_barang)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $barang->nama_barang }}</h1>
                <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 font-mono text-xs font-bold">
                    {{ $barang->kode_barang }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Detail spesifikasi katalog, supplier pemasok, dan riwayat mutasi stok fisik.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.barang.edit', $barang->id) }}" class="px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-xl transition-colors shadow-2xs">
                Edit Barang
            </a>
            <a href="{{ route('admin.barang.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                &larr; Kembali
            </a>
        </div>
    </div>

    <!-- Spesifikasi Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        
        <!-- Info Barang -->
        <div class="md:col-span-2 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-4">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400">Informasi Produk</h2>
            
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-xs text-slate-400 block">Kategori</span>
                    <span class="font-bold text-slate-800">{{ $barang->kategori->nama_kategori ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Kode Kategori</span>
                    <span class="font-mono text-xs font-semibold text-slate-600">{{ $barang->kategori->kode_kategori ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Harga Satuan</span>
                    <span class="font-bold text-slate-900 text-lg">Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Status Stok Fisik</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $barang->stok <= 20 ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                        <span class="w-2 h-2 rounded-full {{ $barang->stok <= 20 ? 'bg-rose-500' : 'bg-emerald-500' }}"></span>
                        {{ $barang->stok }} Unit Tersedia
                    </span>
                </div>
            </div>

            <!-- Supplier Info Box -->
            <div class="mt-6 pt-5 border-t border-slate-100">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Informasi Pemasok (Supplier)</h3>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-start justify-between">
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">{{ $barang->supplier->nama_pt ?? 'Belum ada supplier' }}</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Kode: <span class="font-mono">{{ $barang->supplier->kode_supplier ?? '-' }}</span></p>
                        <p class="text-xs text-slate-600 mt-1">Telepon: {{ $barang->supplier->telepon ?? '-' }} | Email: {{ $barang->supplier->email ?? '-' }}</p>
                        <p class="text-xs text-slate-500 mt-1">Alamat: {{ $barang->supplier->alamat ?? '-' }}</p>
                    </div>
                    @if ($barang->supplier)
                        <a href="{{ route('admin.suppliers.show', $barang->supplier->id) }}" class="text-xs font-bold text-blue-600 hover:underline flex-shrink-0">
                            Lihat Profil Supplier &rarr;
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Card Samping: Cepat Catat Mutasi -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 flex flex-col justify-between">
            <div>
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-2">Tindakan Cepat</h2>
                <p class="text-xs text-slate-500 mb-4">Catat mutasi penerimaan barang masuk atau pengeluaran barang untuk produk ini.</p>
                
                <a href="{{ route('admin.mutasi.create', ['barang_id' => $barang->id]) }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-xs transition-colors mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Catat Mutasi Stok
                </a>
            </div>

            <div class="pt-4 border-t border-slate-100 text-xs text-slate-400">
                Terakhir diupdate: {{ $barang->updated_at->format('d M Y, H:i') }}
            </div>
        </div>

    </div>

    <!-- Riwayat Transaksi Mutasi Khusus Barang Ini -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6">
        <h3 class="text-sm font-bold text-slate-900 mb-4">Riwayat Mutasi Stok Produk</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider">
                        <th class="py-2.5 px-3">Tanggal</th>
                        <th class="py-2.5 px-3">Jenis</th>
                        <th class="py-2.5 px-3 text-right">Jumlah</th>
                        <th class="py-2.5 px-3">Petugas</th>
                        <th class="py-2.5 px-3">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse ($barang->mutasi as $m)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-3 text-slate-500">{{ $m->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 px-3">
                                @if ($m->jenis === 'masuk')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        ↓ Masuk
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">
                                        ↑ Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3 text-right font-bold text-slate-900">{{ number_format($m->jumlah) }} Unit</td>
                            <td class="py-3 px-3 text-slate-600">{{ $m->user->name ?? 'System' }}</td>
                            <td class="py-3 px-3 text-slate-500">{{ $m->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-400">Belum ada riwayat mutasi untuk barang ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
