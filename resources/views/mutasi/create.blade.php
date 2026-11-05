@extends('layouts.app')

@section('title', 'Catat Mutasi Stok')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pencatatan Transaksi Mutasi</h1>
            <p class="text-xs text-slate-500 mt-1">Catat penerimaan barang masuk dari supplier atau pengeluaran barang dari gudang.</p>
        </div>
        <a href="{{ route('admin.mutasi.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 rounded-xl transition-colors">
            &larr; Riwayat Mutasi
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.mutasi.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Pilih Barang -->
            <div>
                <label for="barang_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Pilih Barang <span class="text-rose-500">*</span>
                </label>
                <select name="barang_id" 
                        id="barang_id" 
                        required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-blue-500 transition-all">
                    <option value="">-- Pilih Barang yang Akan Dimutasi --</option>
                    @foreach ($barangList as $b)
                        <option value="{{ $b->id }}" {{ (old('barang_id', request('barang_id')) == $b->id) ? 'selected' : '' }}>
                            {{ $b->nama_barang }} (Kode: {{ $b->kode_barang }} | Stok Fisik: {{ $b->stok }} unit)
                        </option>
                    @endforeach
                </select>
                @error('barang_id')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Mutasi (Masuk vs Keluar) -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Jenis Transaksi Mutasi <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-emerald-400 bg-slate-50/50 cursor-pointer has-checked:border-emerald-500 has-checked:bg-emerald-50/40 transition-colors">
                        <input type="radio" name="jenis" value="masuk" {{ old('jenis', 'masuk') === 'masuk' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="block text-sm font-bold text-slate-900">↓ Barang Masuk</span>
                            <span class="block text-[11px] text-slate-500">Penerimaan dari vendor supplier</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-rose-400 bg-slate-50/50 cursor-pointer has-checked:border-rose-500 has-checked:bg-rose-50/40 transition-colors">
                        <input type="radio" name="jenis" value="keluar" {{ old('jenis') === 'keluar' ? 'checked' : '' }} class="text-rose-600 focus:ring-rose-500">
                        <div>
                            <span class="block text-sm font-bold text-slate-900">↑ Barang Keluar</span>
                            <span class="block text-[11px] text-slate-500">Pengeluaran untuk produksi/lini</span>
                        </div>
                    </label>
                </div>
                @error('jenis')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jumlah Unit -->
            <div>
                <label for="jumlah" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Jumlah Unit Barang <span class="text-rose-500">*</span>
                </label>
                <input type="number" 
                       name="jumlah" 
                       id="jumlah" 
                       min="1"
                       value="{{ old('jumlah', 1) }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-blue-500 transition-all">
                @error('jumlah')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Keterangan Dokumen / Keperluan
                </label>
                <textarea name="keterangan" 
                          id="keterangan" 
                          rows="3"
                          placeholder="Nomor PO / Surat Jalan penerimaan atau divisi pemohon pengeluaran..."
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-blue-500 transition-all">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.mutasi.index') }}" class="px-4 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-xs transition-all">
                    Simpan Transaksi Mutasi
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
