<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketSubscription extends Model
{
    protected $table = 'paket_subscription';

    protected $fillable = [
        'nama', 'slug', 'icon', 'harga', 'jumlah_item',
        'badge', 'deskripsi', 'fitur', 'tidak',
        'highlight', 'aktif',
    ];

    protected $casts = [
        'fitur'     => 'array',
        'tidak'     => 'array',
        'highlight' => 'boolean',
        'aktif'     => 'boolean',
    ];

}
