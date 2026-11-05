@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')
<div class="max-w-3xl space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-[#0f172a] tracking-tight">Tambah Barang</h1>
            <p class="text-xs text-slate-500 mt-1">Masukkan spesifikasi barang, nomor kode unik, supplier, dan stok awal</p>
        </div>
        <a href="{{ route('admin.barang.index') }}" class="px-3.5 py-1.5 text-xs font-medium text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.barang.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="kode_barang" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Kode Barang <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="kode_barang" 
                           id="kode_barang"
                           maxlength="10"
                           value="{{ old('kode_barang', 'BRG' . rand(100000, 999999)) }}"
                           required
                           class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-[#0d6efd] focus:ring-1 focus:ring-[#0d6efd] @error('kode_barang') border-rose-400 @enderror">
                    <p class="text-[11px] text-slate-400 mt-1">Maksimal 10 karakter unik</p>
                    @error('kode_barang')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama_barang" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Nama Barang <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama_barang" 
                           id="nama_barang"
                           value="{{ old('nama_barang') }}"
                           placeholder="Contoh: Sabun Batang Total 10"
                           required
                           class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-[#0d6efd] focus:ring-1 focus:ring-[#0d6efd] @error('nama_barang') border-rose-400 @enderror">
                    <p class="text-[11px] text-slate-400 mt-1">Minimal 3 karakter</p>
                    @error('nama_barang')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="kategori_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Kategori Barang <span class="text-rose-500">*</span>
                    </label>
                    <select name="kategori_id" 
                            id="kategori_id"
                            required
                            class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-[#0d6efd] focus:ring-1 focus:ring-[#0d6efd] @error('kategori_id') border-rose-400 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="supplier_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Supplier <span class="text-rose-500">*</span>
                    </label>
                    <select name="supplier_id" 
                            id="supplier_id"
                            required
                            class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-[#0d6efd] focus:ring-1 focus:ring-[#0d6efd] @error('supplier_id') border-rose-400 @enderror">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($supplierList as $sup)
                            <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>
                                {{ $sup->nama_pt }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="stok" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Jumlah Stok Awal <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" 
                           name="stok" 
                           id="stok"
                           min="0"
                           value="{{ old('stok', 0) }}"
                           required
                           class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-[#0d6efd] focus:ring-1 focus:ring-[#0d6efd] @error('stok') border-rose-400 @enderror">
                    <p class="text-[11px] text-slate-400 mt-1">Minimal 0 (tidak boleh negatif)</p>
                    @error('stok')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="harga_satuan" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Harga Satuan (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" 
                           name="harga_satuan" 
                           id="harga_satuan"
                           min="0"
                           value="{{ old('harga_satuan', 10000) }}"
                           required
                           class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-[#0d6efd] focus:ring-1 focus:ring-[#0d6efd] @error('harga_satuan') border-rose-400 @enderror">
                    <p class="text-[11px] text-slate-400 mt-1">Wajib angka numerik</p>
                    @error('harga_satuan')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <a href="{{ route('admin.barang.index') }}" class="px-4 py-2 text-xs font-medium text-slate-600 hover:text-slate-800 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-[#0d6efd] hover:bg-blue-600 text-white rounded-lg text-xs font-semibold shadow-xs transition-colors">
                    Simpan Barang
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
