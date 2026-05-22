<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preferensi extends Model
{
    protected $table = 'preferensi';

    protected $fillable = [
        'user_id', 'ukuran_atasan', 'ukuran_bawahan',
        'tinggi_badan', 'berat_badan', 'gaya_berpakaian',
        'warna_favorit', 'jenis_pakaian', 'pantangan',
        'catatan_kurator',
    ];

    protected $casts = [
        'gaya_berpakaian' => 'array',
        'warna_favorit'   => 'array',
        'jenis_pakaian'   => 'array',
        'pantangan'       => 'array',
    ];

}
