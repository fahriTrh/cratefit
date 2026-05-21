<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $table = 'inventory_items';

    protected $fillable = [
        'kode_item', 'nama', 'kategori', 'jenis', 'ukuran',
        'warna', 'brand', 'kondisi', 'harga', 'stok',
        'tags', 'foto', 'status',
    ];

    protected $casts = [
        'tags' => 'array',
    ];
}
