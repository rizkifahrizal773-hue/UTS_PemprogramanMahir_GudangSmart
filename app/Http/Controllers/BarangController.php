<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangController extends Controller
{
    /**
     * Tampilkan katalog barang dengan fitur Eager Loading, Search, Filter, dan Pagination.
     */
    public function index(Request $request): View
    {
        // 1. Eager Loading relasi supplier dan kategori guna mencegah masalah N+1 Query Problem
        $query = Barang::with(['supplier', 'kategori']);

        // 2. Search dinamis berdasarkan nama_barang atau kode_barang
        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_barang', 'like', "%{$keyword}%")
                  ->orWhere('kode_barang', 'like', "%{$keyword}%");
            });
        }

        // 3. Filtering berdasarkan kategori_id
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // 4. Pagination 10 data per halaman dengan menjaga parameter query URL
        $barang = $query->latest()->paginate(10)->withQueryString();

        // Data kategori untuk dropdown filter pencarian
        $kategoriList = KategoriBarang::orderBy('nama_kategori', 'asc')->get();

        return view('barang.index', compact('barang', 'kategoriList'));
    }

    /**
     * Tampilkan formulir tambah barang baru
     */
    public function create(): View
    {
        $kategoriList = KategoriBarang::orderBy('nama_kategori', 'asc')->get();
        $supplierList = Supplier::orderBy('nama_pt', 'asc')->get();

        return view('barang.create', compact('kategoriList', 'supplierList'));
    }

    /**
     * Simpan data barang baru menggunakan validasi StoreBarangRequest
     */
    public function store(StoreBarangRequest $request): RedirectResponse
    {
        Barang::create($request->validated());

        return redirect()->route('admin.barang.index')
            ->with('success', 'Data barang berhasil ditambahkan ke katalog inventory.');
    }

    /**
     * Tampilkan detail barang beserta riwayat transaksi/mutasi
     */
    public function show(string $id): View
    {
        $barang = Barang::with(['supplier', 'kategori', 'mutasi.user'])->findOrFail($id);

        return view('barang.show', compact('barang'));
    }

    /**
     * Tampilkan formulir edit barang
     */
    public function edit(string $id): View
    {
        $barang = Barang::findOrFail($id);
        $kategoriList = KategoriBarang::orderBy('nama_kategori', 'asc')->get();
        $supplierList = Supplier::orderBy('nama_pt', 'asc')->get();

        return view('barang.edit', compact('barang', 'kategoriList', 'supplierList'));
    }

    /**
     * Perbarui data barang menggunakan validasi UpdateBarangRequest
     */
    public function update(UpdateBarangRequest $request, string $id): RedirectResponse
    {
        $barang = Barang::findOrFail($id);
        $barang->update($request->validated());

        return redirect()->route('admin.barang.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Hapus barang secara sementara (Soft Delete)
     */
    public function destroy(string $id): RedirectResponse
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('admin.barang.index')
            ->with('success', "Barang '{$barang->nama_barang}' berhasil dipindahkan ke kotak sampah (Soft Deleted).");
    }

    /**
     * Tampilkan daftar data barang yang terhapus sementara (Trash)
     */
    public function trash(): View
    {
        $barang = Barang::onlyTrashed()
            ->with(['supplier', 'kategori'])
            ->latest('deleted_at')
            ->paginate(10);

        return view('barang.trash', compact('barang'));
    }

    /**
     * Pulihkan data barang yang terhapus sementara (Restore)
     */
    public function restore(string $id): RedirectResponse
    {
        $barang = Barang::onlyTrashed()->findOrFail($id);
        $barang->restore();

        return redirect()->route('admin.barang.trash')
            ->with('success', "Barang '{$barang->nama_barang}' berhasil dipulihkan (Restored).");
    }

    /**
     * Hapus data barang secara permanen dari basis data (Force Delete)
     */
    public function forceDelete(string $id): RedirectResponse
    {
        $barang = Barang::onlyTrashed()->findOrFail($id);
        $nama = $barang->nama_barang;
        $barang->forceDelete();

        return redirect()->route('admin.barang.trash')
            ->with('success', "Barang '{$nama}' telah dihapus secara permanen dari sistem.");
    }
}
