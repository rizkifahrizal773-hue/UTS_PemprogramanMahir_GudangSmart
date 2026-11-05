@extends('layouts.app')

@section('title', 'Supplier')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[#0f172a] tracking-tight">Supplier</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar mitra pemasok barang dan suku cadang gudang</p>
        </div>

        @if (auth()->user()?->isManager())
            <a href="{{ route('admin.suppliers.create') }}" class="px-4 py-1.5 bg-[#0d6efd] hover:bg-blue-600 text-white rounded-lg text-xs font-semibold shadow-xs transition-colors">
                + Tambah Supplier
            </a>
        @endif
    </div>

    <!-- Search Section -->
    <div class="space-y-1.5">
        <label for="search" class="block text-sm font-semibold text-slate-800">Search</label>
        <form method="GET" action="{{ route('admin.suppliers.index') }}" class="flex items-center gap-2.5 w-full sm:w-80">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" 
                       name="search" 
                       id="search"
                       value="{{ request('search') }}"
                       placeholder="Cari supplier..." 
                       class="w-full pl-9 pr-3 py-1.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#0d6efd] focus:ring-1 focus:ring-[#0d6efd] transition-all">
            </div>
            @if (request('search'))
                <a href="{{ route('admin.suppliers.index') }}" class="px-2.5 py-1.5 text-xs text-slate-500 hover:text-slate-800">
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
                        <th class="py-4 px-6 w-28">Kode</th>
                        <th class="py-4 px-6">Nama PT / Vendor</th>
                        <th class="py-4 px-6">Kontak</th>
                        <th class="py-4 px-6">Alamat</th>
                        <th class="py-4 px-6 text-center">Jumlah Barang</th>
                        <th class="py-4 px-6 text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($suppliers as $sup)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 font-mono text-xs font-semibold text-slate-500">
                                {{ $sup->kode_supplier }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900">
                                <a href="{{ route('admin.suppliers.show', $sup->id) }}" class="hover:text-[#0d6efd]">
                                    {{ $sup->nama_pt }}
                                </a>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-600">
                                <div class="font-medium text-slate-800">{{ $sup->telepon }}</div>
                                <div class="text-slate-400">{{ $sup->email }}</div>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-500 max-w-xs truncate">
                                {{ $sup->alamat }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                    {{ $sup->barang_count }} Barang
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.suppliers.show', $sup->id) }}" class="px-4 py-1 text-xs font-medium text-white bg-[#0d6efd] hover:bg-blue-600 rounded transition-colors">
                                        View
                                    </a>

                                    @if (auth()->user()?->isManager())
                                        <a href="{{ route('admin.suppliers.edit', $sup->id) }}" class="px-4 py-1 text-xs font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.suppliers.destroy', $sup->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus supplier \'{{ $sup->nama_pt }}\'?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 rounded transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                Tidak ada data supplier.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($suppliers->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                <div class="text-xs text-slate-400">
                    Menampilkan {{ $suppliers->firstItem() ?? 0 }} - {{ $suppliers->lastItem() ?? 0 }} dari {{ $suppliers->total() }} supplier
                </div>
                {{ $suppliers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
