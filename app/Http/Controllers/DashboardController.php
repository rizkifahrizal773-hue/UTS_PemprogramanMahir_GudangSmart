<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\MutasiStok;
use App\Models\Supplier;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama Dashboard Inventory
     */
    public function index(): View
    {
        // 3 Buah Card Ringkasan sesuai instruksi Soal 2
        $totalSupplier = Supplier::count();
        $totalJenisBarang = Barang::count();
        $totalStokFisikGudang = Barang::sum('stok');

        // Data pendukung tambahan untuk dashboard operasional
        $totalKategori = KategoriBarang::count();
        $totalLowStock = Barang::where('stok', '>', 0)->where('stok', '<=', 50)->count();
        $totalOutOfStock = Barang::where('stok', '<=', 0)->count();
        $mutasiTerbaru = MutasiStok::with(['barang', 'user'])
            ->latest()
            ->take(6)
            ->get();

        $barangStokKritis = Barang::with(['kategori', 'supplier'])
            ->where('stok', '<=', 50)
            ->orderBy('stok', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalSupplier',
            'totalJenisBarang',
            'totalStokFisikGudang',
            'totalKategori',
            'totalLowStock',
            'totalOutOfStock',
            'mutasiTerbaru',
            'barangStokKritis'
        ));
    }
}
