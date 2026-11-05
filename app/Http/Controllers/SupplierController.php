<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SupplierController extends Controller
{
    /**
     * Tampilkan daftar supplier dengan pagination dan pencarian
     */
    public function index(Request $request): View
    {
        $query = Supplier::withCount('barang');

        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_pt', 'like', "%{$keyword}%")
                  ->orWhere('kode_supplier', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        $suppliers = $query->latest()->paginate(10)->withQueryString();

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Tampilkan formulir tambah supplier
     */
    public function create(): View
    {
        return view('suppliers.create');
    }

    /**
     * Simpan supplier baru ke basis data
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_supplier' => ['required', 'string', 'max:10', 'unique:suppliers,kode_supplier'],
            'nama_pt' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
        ], [
            'kode_supplier.required' => 'Kode supplier wajib diisi.',
            'kode_supplier.unique' => 'Kode supplier sudah terdaftar.',
            'kode_supplier.max' => 'Kode supplier maksimal 10 karakter.',
            'nama_pt.required' => 'Nama PT / Vendor wajib diisi.',
            'email.required' => 'Email supplier wajib diisi.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'alamat.required' => 'Alamat supplier wajib diisi.',
        ]);

        Supplier::create($validated);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Data supplier berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail supplier beserta katalog barang yang dipasok
     */
    public function show(string $id): View
    {
        $supplier = Supplier::with(['barang.kategori'])->findOrFail($id);

        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Tampilkan formulir edit data supplier
     */
    public function edit(string $id): View
    {
        $supplier = Supplier::findOrFail($id);

        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Perbarui data supplier
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'kode_supplier' => [
                'required',
                'string',
                'max:10',
                Rule::unique('suppliers', 'kode_supplier')->ignore($supplier->id),
            ],
            'nama_pt' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
        ], [
            'kode_supplier.required' => 'Kode supplier wajib diisi.',
            'kode_supplier.unique' => 'Kode supplier sudah digunakan oleh supplier lain.',
            'kode_supplier.max' => 'Kode supplier maksimal 10 karakter.',
            'nama_pt.required' => 'Nama PT wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        $supplier->update($validated);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Data supplier berhasil diperbarui.');
    }

    /**
     * Hapus data supplier (Soft Delete)
     */
    public function destroy(string $id): RedirectResponse
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('admin.suppliers.index')
            ->with('success', "Data supplier '{$supplier->nama_pt}' berhasil dihapus (Soft Delete).");
    }
}
