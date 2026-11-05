@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="max-w-3xl space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-[#0f172a] tracking-tight">Edit Barang</h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui data: {{ $barang->nama_barang }} ({{ $barang->kode_barang }})</p>
        </div>
        <a href="{{ route('admin.barang.index') }}" class="px-3.5 py-1.5 text-xs font-medium text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="kode_barang" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Kode Barang <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="kode_barang" 
                           id="kode_barang"
                           maxlength="10"
                           value="{{ old('kode_barang', $barang->kode_barang) }}"
                           required
                           class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-[#0d6efd] focus:ring-1 focus:ring-[#0d6efd] @error('kode_barang') border-rose-400 @enderror">
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
                           value="{{ old('nama_barang', $barang->nama_barang) }}"
                           required
                           class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-[#0d6efd] focus:ring-1 focus:ring-[#0d6efd] @error('nama_barang') border-rose-400 @enderror">
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
                        @foreach ($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id', $barang->kategori_id) == $kat->id ? 'selected' : '' }}>
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
                        @foreach ($supplierList as $sup)
                            <option value="{{ $sup->id }}" {{ old('supplier_id', $barang->supplier_id) == $sup->id ? 'selected' : '' }}>
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
                        Jumlah Stok <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" 
                           name="stok" 
                           id="stok"
                           min="0"
                           value="{{ old('stok', $barang->stok) }}"
                           required
                           class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-[#0d6efd] focus:ring-1 focus:ring-[#0d6efd] @error('stok') border-rose-400 @enderror">
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
                           value="{{ old('harga_satuan', (int)$barang->harga_satuan) }}"
                           required
                           class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-[#0d6efd] focus:ring-1 focus:ring-[#0d6efd] @error('harga_satuan') border-rose-400 @enderror">
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
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
