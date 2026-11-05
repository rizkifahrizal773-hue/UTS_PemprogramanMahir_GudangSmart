<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'kategori_id',
        'supplier_id',
        'nama_barang',
        'stok',
        'harga_satuan',
    ];

    protected $casts = [
        'stok' => 'integer',
        'harga_satuan' => 'decimal:2',
    ];

    /**
     * Relasi belongsTo ke Supplier
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Relasi belongsTo ke KategoriBarang
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    /**
     * Relasi hasMany ke MutasiStok
     */
    public function mutasi(): HasMany
    {
        return $this->hasMany(MutasiStok::class, 'barang_id');
    }
}
