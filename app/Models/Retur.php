<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
    protected $table = 'returs';

    protected $fillable = [
        'kode_retur',
        'user_id',
        'box_id',
        'kurir_id',
        'item_retur',
        'alasan_retur',
        'catatan_retur',
        'metode_pengembalian',
        'status',
        'catatan_admin',
        'tanggal_batas_retur',
        'tanggal_dijemput',
    ];

    protected $casts = [
        'item_retur'          => 'array',
        'tanggal_batas_retur' => 'datetime',
        'tanggal_dijemput'    => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function box()
    {
        return $this->belongsTo(Box::class);
    }
    public function kurir()
    {
        return $this->belongsTo(User::class, 'kurir_id');
    }
}
