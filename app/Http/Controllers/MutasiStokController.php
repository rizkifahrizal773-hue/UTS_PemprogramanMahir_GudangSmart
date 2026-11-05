<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\MutasiStok;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MutasiStokController extends Controller
{
    /**
     * Tampilkan riwayat mutasi stok barang (masuk/keluar)
     */
    public function index(Request $request): View
    {
        $query = MutasiStok::with(['barang.kategori', 'user']);

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('barang_id')) {
            $query->where('barang_id', $request->barang_id);
        }

        $mutasi = $query->latest()->paginate(15)->withQueryString();
        $barangList = Barang::orderBy('nama_barang', 'asc')->get();

        return view('mutasi.index', compact('mutasi', 'barangList'));
    }

    /**
     * Tampilkan formulir pencatatan transaksi mutasi stok baru
     */
    public function create(): View
    {
        $barangList = Barang::orderBy('nama_barang', 'asc')->get();

        return view('mutasi.create', compact('barangList'));
    }

    /**
     * Simpan transaksi mutasi stok dan perbarui stok fisik pada tabel barang
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'barang_id' => ['required', 'exists:barang,id'],
            'jenis' => ['required', 'in:masuk,keluar'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ], [
            'barang_id.required' => 'Barang wajib dipilih.',
            'jenis.required' => 'Jenis mutasi wajib ditentukan (Masuk atau Keluar).',
            'jumlah.required' => 'Jumlah barang wajib diisi.',
            'jumlah.min' => 'Jumlah barang minimal 1 unit.',
        ]);

        return DB::transaction(function () use ($validated) {
            $barang = Barang::lockForUpdate()->findOrFail($validated['barang_id']);

            if ($validated['jenis'] === 'keluar') {
                if ($barang->stok < $validated['jumlah']) {
                    return back()->withInput()->with('error', "Stok barang '{$barang->nama_barang}' tidak mencukupi. Stok saat ini: {$barang->stok} unit.");
                }
                $barang->decrement('stok', $validated['jumlah']);
            } else {
                $barang->increment('stok', $validated['jumlah']);
            }

            MutasiStok::create([
                'barang_id' => $validated['barang_id'],
                'user_id' => Auth::id(),
                'jenis' => $validated['jenis'],
                'jumlah' => $validated['jumlah'],
                'keterangan' => $validated['keterangan'],
            ]);

            $jenisLabel = $validated['jenis'] === 'masuk' ? 'Penerimaan (Barang Masuk)' : 'Pengeluaran (Barang Keluar)';
            return redirect()->route('admin.mutasi.index')
                ->with('success', "Transaksi {$jenisLabel} sebanyak {$validated['jumlah']} unit untuk '{$barang->nama_barang}' berhasil disimpan.");
        });
    }
}
