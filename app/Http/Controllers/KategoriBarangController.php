<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriBarangController extends Controller
{
    /**
     * Tampilkan daftar kategori barang
     */
    public function index(): View
    {
        $kategori = KategoriBarang::withCount('barang')
            ->orderBy('nama_kategori', 'asc')
            ->get();

        return view('kategori.index', compact('kategori'));
    }

    /**
     * Simpan kategori barang baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_kategori' => ['required', 'string', 'max:20', 'unique:kategori_barang,kode_kategori'],
            'nama_kategori' => ['required', 'string', 'max:100'],
        ], [
            'kode_kategori.required' => 'Kode kategori wajib diisi.',
            'kode_kategori.unique' => 'Kode kategori sudah digunakan.',
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
        ]);

        KategoriBarang::create($validated);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori barang berhasil ditambahkan.');
    }

    /**
     * Hapus kategori barang
     */
    public function destroy(string $id): RedirectResponse
    {
        $kategori = KategoriBarang::withCount('barang')->findOrFail($id);

        if ($kategori->barang_count > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memuat barang.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori barang berhasil dihapus.');
    }
}
