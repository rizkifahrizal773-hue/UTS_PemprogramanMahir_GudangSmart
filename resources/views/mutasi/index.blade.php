@extends('layouts.app')

@section('title', 'Mutasi Stok')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[#0f172a] tracking-tight">Mutasi Stok</h1>
            <p class="text-xs text-slate-500 mt-1">Riwayat transaksi penerimaan barang masuk dan pengeluaran barang</p>
        </div>

        <a href="{{ route('admin.mutasi.create') }}" class="px-4 py-1.5 bg-[#0d6efd] hover:bg-blue-600 text-white rounded-lg text-xs font-semibold shadow-xs transition-colors">
            + Input Transaksi
        </a>
    </div>

    <!-- Filter Form -->
    <div class="space-y-1.5">
        <label class="block text-sm font-semibold text-slate-800">Filter</label>
        <form method="GET" action="{{ route('admin.mutasi.index') }}" class="flex flex-col sm:flex-row items-center gap-2.5">
            <div class="w-full sm:w-48">
                <select name="jenis" onchange="this.form.submit()" class="w-full px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-700 focus:outline-none focus:border-[#0d6efd]">
                    <option value="">Semua Jenis</option>
                    <option value="masuk" {{ request('jenis') === 'masuk' ? 'selected' : '' }}>Barang Masuk</option>
                    <option value="keluar" {{ request('jenis') === 'keluar' ? 'selected' : '' }}>Barang Keluar</option>
                </select>
            </div>

            <div class="w-full sm:w-64">
                <select name="barang_id" onchange="this.form.submit()" class="w-full px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-700 focus:outline-none focus:border-[#0d6efd]">
                    <option value="">Semua Barang</option>
                    @foreach ($barangList as $b)
                        <option value="{{ $b->id }}" {{ request('barang_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if (request()->hasAny(['jenis', 'barang_id']))
                <a href="{{ route('admin.mutasi.index') }}" class="px-3 py-1.5 text-xs text-slate-500 hover:text-slate-800 font-medium">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-900 font-bold">
                        <th class="py-4 px-6">Waktu</th>
                        <th class="py-4 px-6">Barang</th>
                        <th class="py-4 px-6">Jenis Mutasi</th>
                        <th class="py-4 px-6 text-right">Jumlah</th>
                        <th class="py-4 px-6">Petugas</th>
                        <th class="py-4 px-6">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($mutasi as $m)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 text-xs text-slate-500 whitespace-nowrap">
                                {{ $m->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-4 px-6 font-medium text-slate-900">
                                <a href="{{ route('admin.barang.show', $m->barang_id) }}" class="hover:text-[#0d6efd]">
                                    {{ $m->barang->nama_barang ?? '-' }}
                                </a>
                                <span class="text-xs text-slate-400 block font-mono">{{ $m->barang->kode_barang ?? '-' }}</span>
                            </td>
                            <td class="py-4 px-6">
                                @if ($m->jenis === 'masuk')
                                    <span class="inline-block px-2.5 py-0.5 rounded text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                        Masuk
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-0.5 rounded text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/60">
                                        Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right font-semibold text-slate-900">
                                {{ number_format($m->jumlah) }} Unit
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-600">
                                {{ $m->user->name ?? 'System' }}
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-400 max-w-xs truncate">
                                {{ $m->keterangan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                Belum ada catatan mutasi stok.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($mutasi->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                <div class="text-xs text-slate-400">
                    Menampilkan {{ $mutasi->firstItem() ?? 0 }} - {{ $mutasi->lastItem() ?? 0 }} dari {{ $mutasi->total() }} mutasi
                </div>
                {{ $mutasi->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
