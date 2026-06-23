<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $table = 'boxes';

    protected $fillable = [
        'kode_box',
        'langganan_id',
        'user_id',
        'kurator_id',
        'kurir_id',
        'status',
        'nomor_resi',
        'ekspedisi',
        'catatan_kurasi',
        'catatan_internal',
        'tanggal_dikurasi',
        'tanggal_dikirim',
        'tanggal_tiba',
    ];

    protected $casts = [
        'tanggal_dikurasi' => 'datetime',
        'tanggal_dikirim'  => 'datetime',
        'tanggal_tiba'     => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(BoxItem::class)->orderBy('urutan');
    }

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kurator()
    {
        return $this->belongsTo(User::class, 'kurator_id');
    }

    public function langganan()
    {
        return $this->belongsTo(Langganan::class);
    }

    // Tambahkan di dalam class Box
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function ratingKurator()
    {
        return $this->ratings()->where('tipe', 'kurator')->first();
    }

    public function ratingKurir()
    {
        return $this->ratings()->where('tipe', 'kurir')->first();
    }
}
