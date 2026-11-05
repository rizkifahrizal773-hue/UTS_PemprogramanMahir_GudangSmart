@extends('layouts.app')

@section('title', 'Edit Supplier: ' . $supplier->nama_pt)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Edit Data Supplier</h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui data: {{ $supplier->nama_pt }} ({{ $supplier->kode_supplier }})</p>
        </div>
        <a href="{{ route('admin.suppliers.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 rounded-xl transition-colors">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="kode_supplier" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Kode Supplier <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       name="kode_supplier" 
                       id="kode_supplier"
                       maxlength="10"
                       value="{{ old('kode_supplier', $supplier->kode_supplier) }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm font-mono text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                @error('kode_supplier')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nama_pt" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nama Perusahaan (PT/CV) <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       name="nama_pt" 
                       id="nama_pt"
                       value="{{ old('nama_pt', $supplier->nama_pt) }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                @error('nama_pt')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email"
                           value="{{ old('email', $supplier->email) }}"
                           required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    @error('email')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="telepon" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nomor Telepon <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="telepon" 
                           id="telepon"
                           value="{{ old('telepon', $supplier->telepon) }}"
                           required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    @error('telepon')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="alamat" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Alamat Lengkap <span class="text-rose-500">*</span>
                </label>
                <textarea name="alamat" 
                          id="alamat" 
                          rows="3"
                          required
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">{{ old('alamat', $supplier->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.suppliers.index') }}" class="px-4 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-xs transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
