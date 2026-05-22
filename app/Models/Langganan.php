<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Langganan extends Model
{
    protected $table = 'langganan';

    protected $fillable = [
        'user_id',
        'paket_id',
        'alamat_id',
        'periode',
        'metode_bayar',
        'status',
        'tanggal_mulai',
        'tanggal_pengiriman_berikutnya',
        'tanggal_batal',
    ];

    protected $casts = [
        'tanggal_mulai'                 => 'date',
        'tanggal_pengiriman_berikutnya' => 'date',
        'tanggal_batal'                 => 'datetime',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paket()
    {
        return $this->belongsTo(PaketSubscription::class, 'paket_id');
    }

    public function alamat()
    {
        return $this->belongsTo(AlamatPengiriman::class, 'alamat_id');
    }

    // Scope
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
