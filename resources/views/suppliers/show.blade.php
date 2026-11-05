@extends('layouts.app')

@section('title', 'Detail Supplier: ' . $supplier->nama_pt)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $supplier->nama_pt }}</h1>
                <span class="px-2.5 py-0.5 rounded-full bg-slate-100 font-mono text-xs font-bold text-slate-700">
                    {{ $supplier->kode_supplier }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Profil supplier dan daftar katalog barang yang dipasok ke GudangSmart.</p>
        </div>

        <div class="flex items-center gap-2">
            @if (auth()->user()?->isManager())
                <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-xl transition-colors shadow-2xs">
                    Edit Data
                </a>
            @endif
            <a href="{{ route('admin.suppliers.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                &larr; Kembali
            </a>
        </div>
    </div>

    <!-- Info Box -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div>
            <span class="text-xs text-slate-400 block font-bold uppercase tracking-wider">Email Kontak</span>
            <span class="font-semibold text-slate-800 text-sm mt-0.5 block">{{ $supplier->email }}</span>
        </div>
        <div>
            <span class="text-xs text-slate-400 block font-bold uppercase tracking-wider">Nomor Telepon</span>
            <span class="font-semibold text-slate-800 text-sm mt-0.5 block">{{ $supplier->telepon }}</span>
        </div>
        <div>
            <span class="text-xs text-slate-400 block font-bold uppercase tracking-wider">Total Barang Dipasok</span>
            <span class="font-bold text-blue-600 text-sm mt-0.5 block">{{ $supplier->barang->count() }} Jenis Barang</span>
        </div>
        <div class="sm:col-span-3 pt-4 border-t border-slate-100">
            <span class="text-xs text-slate-400 block font-bold uppercase tracking-wider">Alamat Fasilitas / Kantor</span>
            <p class="text-sm text-slate-700 mt-0.5">{{ $supplier->alamat }}</p>
        </div>
    </div>

    <!-- Daftar Barang yang Dipasok oleh Supplier Ini (Relasi hasMany) -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">Katalog Barang Dari Supplier Ini</h2>
            <span class="text-xs text-slate-500 font-medium">{{ $supplier->barang->count() }} Item Terdaftar</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider">
                        <th class="py-2.5 px-3">Kode</th>
                        <th class="py-2.5 px-3">Nama Barang</th>
                        <th class="py-2.5 px-3">Kategori</th>
                        <th class="py-2.5 px-3 text-center">Stok</th>
                        <th class="py-2.5 px-3 text-right">Harga Satuan</th>
                        <th class="py-2.5 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse ($supplier->barang as $b)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-3 font-mono font-bold text-slate-500">{{ $b->kode_barang }}</td>
                            <td class="py-3 px-3 font-semibold text-slate-900">{{ $b->nama_barang }}</td>
                            <td class="py-3 px-3 text-slate-600">{{ $b->kategori->nama_kategori ?? '-' }}</td>
                            <td class="py-3 px-3 text-center font-bold text-slate-800">{{ $b->stok }}</td>
                            <td class="py-3 px-3 text-right text-slate-800">Rp {{ number_format($b->harga_satuan, 0, ',', '.') }}</td>
                            <td class="py-3 px-3 text-center">
                                <a href="{{ route('admin.barang.show', $b->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                    Detail &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">
                                Supplier ini belum memiliki data barang yang terhubung.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
