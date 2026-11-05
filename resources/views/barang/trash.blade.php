@extends('layouts.app')

@section('title', 'Kotak Sampah (Trash) - Barang')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Kotak Sampah (Trash)</h1>
                <span class="px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-700 text-xs font-bold">
                    Soft Deleted
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Daftar barang yang dihapus sementara. Anda dapat memulihkan (Restore) atau menghapus secara permanen (Force Delete).</p>
        </div>

        <a href="{{ route('admin.barang.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-xl transition-colors shadow-2xs">
            &larr; Kembali ke Katalog Barang
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-900 font-bold text-sm bg-rose-50/40">
                        <th class="py-3.5 px-5">Kode</th>
                        <th class="py-3.5 px-5">Nama Barang</th>
                        <th class="py-3.5 px-5">Kategori</th>
                        <th class="py-3.5 px-5">Supplier</th>
                        <th class="py-3.5 px-5">Dihapus Pada</th>
                        <th class="py-3.5 px-5 text-center">Tindakan Pemulihan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse ($barang as $item)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-3.5 px-5 font-mono text-xs font-bold text-slate-500">
                                {{ $item->kode_barang }}
                            </td>
                            <td class="py-3.5 px-5 font-bold text-slate-900">
                                {{ $item->nama_barang }}
                            </td>
                            <td class="py-3.5 px-5 text-slate-600">
                                {{ $item->kategori->nama_kategori ?? '-' }}
                            </td>
                            <td class="py-3.5 px-5 text-slate-600">
                                {{ $item->supplier->nama_pt ?? '-' }}
                            </td>
                            <td class="py-3.5 px-5 text-xs text-rose-600 font-medium">
                                {{ $item->deleted_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Restore Button (Manager Only) -->
                                    @if (auth()->user()?->isManager())
                                        <form action="{{ route('admin.barang.restore', $item->id) }}" method="POST" onsubmit="return confirm('Pulihkan data barang \'{{ $item->nama_barang }}\'?')">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-2xs transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                Restore
                                            </button>
                                        </form>

                                        <!-- Force Delete Button (Manager Only) -->
                                        <form action="{{ route('admin.barang.forceDelete', $item->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Barang ini akan DIHAPUS PERMANEN dari basis data dan tidak dapat dikembalikan. Lanjutkan?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold shadow-2xs transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus Permanen
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Hanya Manager</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <p class="font-semibold text-slate-600">Kotak sampah kosong.</p>
                                <p class="text-xs text-slate-400 mt-1">Tidak ada data barang yang sedang terhapus sementara.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($barang->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $barang->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
