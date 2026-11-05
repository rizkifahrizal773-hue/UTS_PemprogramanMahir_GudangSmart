<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\MutasiStok;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Pengguna (Manager & Staff Gudang)
        $manager = User::firstOrCreate(
            ['email' => 'manager@gudangsmart.com'],
            [
                'name' => 'Budi Santoso (Manager)',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ]
        );

        $staff = User::firstOrCreate(
            ['email' => 'staff@gudangsmart.com'],
            [
                'name' => 'Ahmad Fauzi (Staff)',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );

        // 2. Sekurang-kurangnya 5 Kategori Barang
        $kategoriList = [
            ['kode_kategori' => 'KAT001', 'nama_kategori' => 'Suku Cadang Mesin'],
            ['kode_kategori' => 'KAT002', 'nama_kategori' => 'Bahan Baku Industri'],
            ['kode_kategori' => 'KAT003', 'nama_kategori' => 'Perkakas & Alat Kerja'],
            ['kode_kategori' => 'KAT004', 'nama_kategori' => 'Kemasan & Palet'],
            ['kode_kategori' => 'KAT005', 'nama_kategori' => 'Bahan Kimia & Pelumas'],
            ['kode_kategori' => 'KAT006', 'nama_kategori' => 'Consumer Goods & Logistik'],
        ];

        $kategoriModels = [];
        foreach ($kategoriList as $kat) {
            $kategoriModels[] = KategoriBarang::firstOrCreate(
                ['kode_kategori' => $kat['kode_kategori']],
                ['nama_kategori' => $kat['nama_kategori']]
            );
        }

        // 3. Sekurang-kurangnya 10 Supplier
        $supplierList = [
            ['kode_supplier' => 'SUP0000001', 'nama_pt' => 'PT Mitra Logistik Mandiri', 'email' => 'contact@mitralogistik.co.id', 'telepon' => '081234567801', 'alamat' => 'Kawasan Industri Pulogadung Blok A1, Jakarta Timur'],
            ['kode_supplier' => 'SUP0000002', 'nama_pt' => 'PT Baja Perkasa Nusantara', 'email' => 'sales@bajaperkasa.co.id', 'telepon' => '081234567802', 'alamat' => 'Jl. Industri Raya No. 45, Cikarang, Bekasi'],
            ['kode_supplier' => 'SUP0000003', 'nama_pt' => 'PT Sumber Kimia Abadi', 'email' => 'info@sumberkimia.co.id', 'telepon' => '081234567803', 'alamat' => 'Jl. Rungkut Industri III No. 12, Surabaya'],
            ['kode_supplier' => 'SUP0000004', 'nama_pt' => 'PT Dwi Jaya Sentosa', 'email' => 'admin@dwijaya.com', 'telepon' => '081234567804', 'alamat' => 'Jl. Gatot Subroto No. 88, Semarang'],
            ['kode_supplier' => 'SUP0000005', 'nama_pt' => 'PT Prima Packaging Indonesia', 'email' => 'order@primapack.id', 'telepon' => '081234567805', 'alamat' => 'Kawasan Industri Jababeka 2, Cikarang'],
            ['kode_supplier' => 'SUP0000006', 'nama_pt' => 'PT Tri Tirta Makmur', 'email' => 'sales@tritirta.co.id', 'telepon' => '081234567806', 'alamat' => 'Jl. Raya Bogor KM 32, Depok'],
            ['kode_supplier' => 'SUP0000007', 'nama_pt' => 'PT Unilever Supply Chain ID', 'email' => 'corp@unilever-vendor.id', 'telepon' => '081234567807', 'alamat' => 'BSD Green Office Park, Tangerang'],
            ['kode_supplier' => 'SUP0000008', 'nama_pt' => 'PT Kapal Api Distributor', 'email' => 'gudang@kapalapidist.com', 'telepon' => '081234567808', 'alamat' => 'Kawasan Industri Sidoarjo Blok B, Jawa Timur'],
            ['kode_supplier' => 'SUP0000009', 'nama_pt' => 'PT Kencana Tools & Fastener', 'email' => 'info@kencanateknik.co.id', 'telepon' => '081234567809', 'alamat' => 'Kawasan Industri Karawang Barat, Karawang'],
            ['kode_supplier' => 'SUP0000010', 'nama_pt' => 'PT Sinar Aneka Pelumas', 'email' => 'order@sinarpelumas.co.id', 'telepon' => '081234567810', 'alamat' => 'Jl. Pelabuhan Tanjung Perak No. 15, Surabaya'],
        ];

        $supplierModels = [];
        foreach ($supplierList as $sup) {
            $supplierModels[] = Supplier::firstOrCreate(
                ['kode_supplier' => $sup['kode_supplier']],
                $sup
            );
        }

        // 4. Sekurang-kurangnya 20 Data Sampel Barang
        $barangData = [
            // Barang dari referensi tampilan
            ['kode_barang' => 'BRG0000001', 'kat_idx' => 5, 'sup_idx' => 6, 'nama_barang' => 'Sabun Batang Anti Bakteri Total 10 (Lifebuoy)', 'stok' => 42, 'harga' => 4500],
            ['kode_barang' => 'BRG0000002', 'kat_idx' => 5, 'sup_idx' => 5, 'nama_barang' => 'Air Mineral 150ml Gelas (Pelangi)', 'stok' => 839, 'harga' => 18000],
            ['kode_barang' => 'BRG0000003', 'kat_idx' => 5, 'sup_idx' => 6, 'nama_barang' => 'Dove Glowing Ritual Shampoo 100ml', 'stok' => 270, 'harga' => 24500],
            ['kode_barang' => 'BRG0000004', 'kat_idx' => 5, 'sup_idx' => 7, 'nama_barang' => 'Kopi Bubuk Kapal Api Special 100gr', 'stok' => 399, 'harga' => 8500],
            ['kode_barang' => 'BRG0000005', 'kat_idx' => 5, 'sup_idx' => 6, 'nama_barang' => 'SUNLIGHT Jeruk Nipis Refill 100ml', 'stok' => 129, 'harga' => 7000],

            // Komponen & Manufaktur Industri
            ['kode_barang' => 'BRG0000006', 'kat_idx' => 0, 'sup_idx' => 8, 'nama_barang' => 'Ball Bearing Deep Groove 6205-2RS SKF', 'stok' => 150, 'harga' => 45000],
            ['kode_barang' => 'BRG0000007', 'kat_idx' => 0, 'sup_idx' => 8, 'nama_barang' => 'Baut Hex Head Baja High Tensile M12x50', 'stok' => 1200, 'harga' => 3500],
            ['kode_barang' => 'BRG0000008', 'kat_idx' => 0, 'sup_idx' => 1, 'nama_barang' => 'Sprocket Rantai Mesin Konveyor 40T', 'stok' => 45, 'harga' => 185000],
            ['kode_barang' => 'BRG0000009', 'kat_idx' => 1, 'sup_idx' => 1, 'nama_barang' => 'Plat Baja Seamless Carbon 3mm x 1.2m x 2.4m', 'stok' => 25, 'harga' => 950000],
            ['kode_barang' => 'BRG0000010', 'kat_idx' => 1, 'sup_idx' => 1, 'nama_barang' => 'Batang Aluminium Hollow 40x40 Tebal 2mm', 'stok' => 90, 'harga' => 125000],
            ['kode_barang' => 'BRG0000011', 'kat_idx' => 4, 'sup_idx' => 9, 'nama_barang' => 'Oli Pelumas Hidrolik Shell Tellus S2 M46 Drum 209L', 'stok' => 12, 'harga' => 7500000],
            ['kode_barang' => 'BRG0000012', 'kat_idx' => 4, 'sup_idx' => 2, 'nama_barang' => 'Pelarut Degreaser Industri Drum 20L', 'stok' => 35, 'harga' => 480000],
            ['kode_barang' => 'BRG0000013', 'kat_idx' => 3, 'sup_idx' => 4, 'nama_barang' => 'Palet Kayu Ekspor ISPM-15 120x100 cm', 'stok' => 350, 'harga' => 110000],
            ['kode_barang' => 'BRG0000014', 'kat_idx' => 3, 'sup_idx' => 4, 'nama_barang' => 'Plastik Stretch Film Roll 500m Tebal 17 Micron', 'stok' => 210, 'harga' => 68000],
            ['kode_barang' => 'BRG0000015', 'kat_idx' => 3, 'sup_idx' => 4, 'nama_barang' => 'Karton Boks Master Corrugated K150/M125/K150', 'stok' => 600, 'harga' => 12500],
            ['kode_barang' => 'BRG0000016', 'kat_idx' => 2, 'sup_idx' => 8, 'nama_barang' => 'Kunci Momen Torsi Digital 1/2" 40-200 Nm', 'stok' => 18, 'harga' => 1350000],
            ['kode_barang' => 'BRG0000017', 'kat_idx' => 2, 'sup_idx' => 8, 'nama_barang' => 'Mesin Gerinda Tangan 4 Inch Bosch GWS 060', 'stok' => 22, 'harga' => 495000],
            ['kode_barang' => 'BRG0000018', 'kat_idx' => 0, 'sup_idx' => 1, 'nama_barang' => 'V-Belt Karet Bando Tipe B-52', 'stok' => 80, 'harga' => 52000],
            ['kode_barang' => 'BRG0000019', 'kat_idx' => 1, 'sup_idx' => 1, 'nama_barang' => 'Kawat Las Kobelco LB-52 3.2mm Dus 20kg', 'stok' => 65, 'harga' => 520000],
            ['kode_barang' => 'BRG0000020', 'kat_idx' => 4, 'sup_idx' => 2, 'nama_barang' => 'Grease Pelumas Lithium EP-2 Pail 15kg', 'stok' => 28, 'harga' => 620000],
            ['kode_barang' => 'BRG0000021', 'kat_idx' => 0, 'sup_idx' => 0, 'nama_barang' => 'Solenoid Valve Udara Pneumatik 24V DC 5/2 Way', 'stok' => 40, 'harga' => 275000],
        ];

        $createdBarang = [];
        foreach ($barangData as $item) {
            $createdBarang[] = Barang::firstOrCreate(
                ['kode_barang' => $item['kode_barang']],
                [
                    'kategori_id' => $kategoriModels[$item['kat_idx']]->id,
                    'supplier_id' => $supplierModels[$item['sup_idx']]->id,
                    'nama_barang' => $item['nama_barang'],
                    'stok' => $item['stok'],
                    'harga_satuan' => $item['harga'],
                ]
            );
        }

        // 5. Sample Mutasi Stok
        if (count($createdBarang) > 0) {
            MutasiStok::firstOrCreate(
                ['keterangan' => 'Penerimaan batch awal barang masuk dari supplier'],
                [
                    'barang_id' => $createdBarang[0]->id,
                    'user_id' => $staff->id,
                    'jenis' => 'masuk',
                    'jumlah' => 50,
                ]
            );

            MutasiStok::firstOrCreate(
                ['keterangan' => 'Pengeluaran untuk kebutuhan lini packaging shift pagi'],
                [
                    'barang_id' => $createdBarang[0]->id,
                    'user_id' => $staff->id,
                    'jenis' => 'keluar',
                    'jumlah' => 8,
                ]
            );
        }
    }
}
