@extends('layouts.app')

@section('title', 'Kategori Barang')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kategori Barang</h1>
            <p class="text-xs text-slate-500 mt-1">Klasifikasi dan segmentasi jenis barang inventaris manufaktur.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Formulir Tambah Kategori (Manager Only) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 h-fit">
            <h2 class="text-base font-bold text-slate-900 mb-1">Tambah Kategori Baru</h2>
            <p class="text-xs text-slate-500 mb-4">Tambahkan segmen jenis barang baru ke dalam sistem.</p>

            @if (auth()->user()?->isManager())
                <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="kode_kategori" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Kode Kategori <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="kode_kategori" 
                               id="kode_kategori" 
                               value="{{ old('kode_kategori', 'KAT' . rand(100, 999)) }}"
                               required
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm font-mono text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-blue-500">
                        @error('kode_kategori')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_kategori" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Nama Kategori <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="nama_kategori" 
                               id="nama_kategori" 
                               value="{{ old('nama_kategori') }}"
                               placeholder="Contoh: Alat Keselamatan (K3)"
                               required
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-blue-500">
                        @error('nama_kategori')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-xs transition-colors">
                        Simpan Kategori
                    </button>
                </form>
            @else
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-500">
                    Penambahan kategori baru hanya dapat dilakukan oleh pengguna dengan hak akses <strong>Manager Gudang</strong>.
                </div>
            @endif
        </div>

        <!-- Tabel Daftar Kategori (2 Kolom) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <h2 class="text-base font-bold text-slate-900">Daftar Kategori Terdaftar</h2>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
                    Total: {{ $kategori->count() }} Kategori
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 font-bold text-xs uppercase tracking-wider bg-slate-50/50">
                            <th class="py-3 px-5">Kode</th>
                            <th class="py-3 px-5">Nama Kategori</th>
                            <th class="py-3 px-5 text-center">Jumlah Barang</th>
                            <th class="py-3 px-5 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse ($kategori as $kat)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-5 font-mono text-xs font-bold text-slate-600">
                                    {{ $kat->kode_kategori }}
                                </td>
                                <td class="py-3.5 px-5 font-bold text-slate-900">
                                    {{ $kat->nama_kategori }}
                                </td>
                                <td class="py-3.5 px-5 text-center">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                                        {{ $kat->barang_count }} SKU
                                    </span>
                                </td>
                                <td class="py-3.5 px-5 text-center">
                                    @if (auth()->user()?->isManager() && $kat->barang_count === 0)
                                        <form action="{{ route('admin.kategori.destroy', $kat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-semibold">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
