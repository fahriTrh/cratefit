<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatPengiriman extends Model
{
    protected $table = 'alamat_pengiriman';

    protected $fillable = [
        'user_id', 'label', 'nama_penerima', 'no_telepon',
        'alamat_lengkap', 'kelurahan', 'kecamatan',
        'kota', 'provinsi', 'kode_pos', 'catatan_kurir', 'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

}
