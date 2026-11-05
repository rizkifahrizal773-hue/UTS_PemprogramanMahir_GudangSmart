<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\MutasiStok;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GudangSmartTest extends TestCase
{
    use RefreshDatabase;

    protected User $manager;
    protected User $staff;
    protected KategoriBarang $kategori;
    protected Supplier $supplier;

    protected function setUp(): void
    {
        parent::setUp();

        $this->manager = User::factory()->create([
            'name' => 'Budi Manager',
            'email' => 'manager@test.com',
            'role' => 'manager',
        ]);

        $this->staff = User::factory()->create([
            'name' => 'Ahmad Staff',
            'email' => 'staff@test.com',
            'role' => 'staff',
        ]);

        $this->kategori = KategoriBarang::create([
            'kode_kategori' => 'KAT001',
            'nama_kategori' => 'Suku Cadang Mesin',
        ]);

        $this->supplier = Supplier::create([
            'kode_supplier' => 'SUP0000001',
            'nama_pt' => 'PT Mitra Logistik',
            'email' => 'supplier@test.com',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Industri No. 1',
        ]);
    }

    /**
     * Soal 1 & 5: Pengujian Autentikasi dan Proteksi Rute
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_login_and_access_dashboard(): void
    {
        $response = $this->post(route('login.post'), [
            'email' => 'manager@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->manager);
    }

    /**
     * Soal 2: Master Layout & 3 Card Ringkasan pada Dashboard
     */
    public function test_dashboard_displays_3_summary_cards(): void
    {
        Barang::create([
            'kode_barang' => 'BRG0000001',
            'kategori_id' => $this->kategori->id,
            'supplier_id' => $this->supplier->id,
            'nama_barang' => 'Bearing 6205',
            'stok' => 100,
            'harga_satuan' => 50000,
        ]);

        $response = $this->actingAs($this->manager)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Inventory');
        // Memastikan 3 judul Card Ringkasan ada di antarmuka
        $response->assertSee('Total Supplier Terdaftar');
        $response->assertSee('Total Jenis Barang (SKU)');
        $response->assertSee('Total Stok Fisik Gudang (Unit)');
    }

    /**
     * Soal 4: Form Request Validation untuk StoreBarangRequest
     */
    public function test_store_barang_validation_rules(): void
    {
        // 1. Data kosong harus gagal validasi
        $response = $this->actingAs($this->manager)->post(route('admin.barang.store'), []);
        $response->assertSessionHasErrors(['kode_barang', 'nama_barang', 'stok', 'harga_satuan', 'kategori_id', 'supplier_id']);

        // 2. Kode barang maksimal 10 karakter & nama_barang minimal 3 karakter
        $response = $this->actingAs($this->manager)->post(route('admin.barang.store'), [
            'kode_barang' => 'BRG123456789999', // > 10 char
            'nama_barang' => 'ab', // < 3 char
            'stok' => -5, // negatif
            'harga_satuan' => 'bukan_angka',
            'kategori_id' => 9999,
            'supplier_id' => 9999,
        ]);

        $response->assertSessionHasErrors(['kode_barang', 'nama_barang', 'stok', 'harga_satuan', 'kategori_id', 'supplier_id']);
    }

    /**
     * Soal 4: Search & Filter pada BarangController
     */
    public function test_barang_search_and_filter(): void
    {
        $b1 = Barang::create([
            'kode_barang' => 'BRG0000001',
            'kategori_id' => $this->kategori->id,
            'supplier_id' => $this->supplier->id,
            'nama_barang' => 'Bearing SKF',
            'stok' => 50,
            'harga_satuan' => 45000,
        ]);

        $b2 = Barang::create([
            'kode_barang' => 'BRG0000002',
            'kategori_id' => $this->kategori->id,
            'supplier_id' => $this->supplier->id,
            'nama_barang' => 'Baut Baja Hex',
            'stok' => 200,
            'harga_satuan' => 3000,
        ]);

        // Search by keyword
        $response = $this->actingAs($this->staff)->get(route('admin.barang.index', ['search' => 'Bearing']));
        $response->assertSee('Bearing SKF');
        $response->assertDontSee('Baut Baja Hex');
    }

    /**
     * Soal 4: Operasi Soft Delete (Hapus Sementara, Trash, Restore, Force Delete)
     */
    public function test_soft_delete_restore_and_force_delete(): void
    {
        $barang = Barang::create([
            'kode_barang' => 'BRG0000099',
            'kategori_id' => $this->kategori->id,
            'supplier_id' => $this->supplier->id,
            'nama_barang' => 'Barang Uji Hapus',
            'stok' => 10,
            'harga_satuan' => 15000,
        ]);

        // 1. Soft Delete oleh Manager
        $this->actingAs($this->manager)->delete(route('admin.barang.destroy', $barang->id));
        $this->assertSoftDeleted('barang', ['id' => $barang->id]);

        // 2. Tampil di Kotak Sampah (Trash)
        $response = $this->actingAs($this->manager)->get(route('admin.barang.trash'));
        $response->assertSee('Barang Uji Hapus');

        // 3. Restore
        $this->actingAs($this->manager)->post(route('admin.barang.restore', $barang->id));
        $this->assertNotSoftDeleted('barang', ['id' => $barang->id]);

        // 4. Force Delete (Hapus Permanen)
        $this->actingAs($this->manager)->delete(route('admin.barang.destroy', $barang->id));
        $this->actingAs($this->manager)->delete(route('admin.barang.forceDelete', $barang->id));
        $this->assertDatabaseMissing('barang', ['id' => $barang->id]);
    }

    /**
     * Soal 5: Proteksi Hak Akses Role (Staff vs Manager)
     */
    public function test_staff_cannot_delete_barang(): void
    {
        $barang = Barang::create([
            'kode_barang' => 'BRG0000088',
            'kategori_id' => $this->kategori->id,
            'supplier_id' => $this->supplier->id,
            'nama_barang' => 'Barang Proteksi',
            'stok' => 20,
            'harga_satuan' => 25000,
        ]);

        // Staff mencoba menghapus barang -> harus ditolak oleh CheckRole middleware
        $response = $this->actingAs($this->staff)->delete(route('admin.barang.destroy', $barang->id));
        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error');

        // Pastikan barang tidak terhapus
        $this->assertDatabaseHas('barang', ['id' => $barang->id, 'deleted_at' => null]);
    }

    public function test_staff_cannot_edit_supplier(): void
    {
        // Staff mencoba mengakses form edit supplier -> harus ditolak
        $response = $this->actingAs($this->staff)->get(route('admin.suppliers.edit', $this->supplier->id));
        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error');
    }

    /**
     * Soal 4: Transaksi Mutasi Stok (Penerimaan & Pengeluaran)
     */
    public function test_mutasi_stok_updates_inventory(): void
    {
        $barang = Barang::create([
            'kode_barang' => 'BRG0000077',
            'kategori_id' => $this->kategori->id,
            'supplier_id' => $this->supplier->id,
            'nama_barang' => 'Barang Mutasi',
            'stok' => 50,
            'harga_satuan' => 10000,
        ]);

        // 1. Barang Masuk (+30 unit)
        $this->actingAs($this->staff)->post(route('admin.mutasi.store'), [
            'barang_id' => $barang->id,
            'jenis' => 'masuk',
            'jumlah' => 30,
            'keterangan' => 'Penerimaan batch baru',
        ]);

        $barang->refresh();
        $this->assertEquals(80, $barang->stok);

        // 2. Barang Keluar (-20 unit)
        $this->actingAs($this->staff)->post(route('admin.mutasi.store'), [
            'barang_id' => $barang->id,
            'jenis' => 'keluar',
            'jumlah' => 20,
            'keterangan' => 'Pengeluaran untuk perakitan',
        ]);

        $barang->refresh();
        $this->assertEquals(60, $barang->stok);
    }
}
