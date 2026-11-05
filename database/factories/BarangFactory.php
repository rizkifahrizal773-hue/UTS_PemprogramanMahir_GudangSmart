<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    protected $model = Barang::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $items = [
            'Baut Baja Hex M12',
            'Bearing Ball 6204-2RS',
            'Minyak Pelumas Industri 5L',
            'Kabel Serabut Tembaga 2.5mm',
            'Plat Aluminium 2mm x 1m',
            'Valve Bola Stainless Steel 1/2"',
            'Sabuk Konveyor Karet 2 Ply',
            'Pipa Seamless Carbon Steel 2"',
            'Filter Udara Kompresor HD',
            'Gearbox Reducer Motor 1HP',
            'Seal Karet Silikon Tahan Panas',
            'Kardus Corrugated Box 40x30x20',
            'Stretch Film Plastik Wrap 500m',
            'Palet Plastik Heavy Duty 120x100',
            'Cat Enamel Anti Karat 20L',
        ];

        return [
            'kode_barang' => 'BRG' . fake()->unique()->numerify('######'),
            'kategori_id' => KategoriBarang::inRandomOrder()->first()?->id ?? KategoriBarang::factory(),
            'supplier_id' => Supplier::inRandomOrder()->first()?->id ?? Supplier::factory(),
            'nama_barang' => fake()->randomElement($items) . ' - ' . fake()->word(),
            'stok' => fake()->numberBetween(15, 650),
            'harga_satuan' => fake()->numberBetween(25000, 1850000),
        ];
    }
}
