<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function langganan()
    {
        return $this->hasMany(Langganan::class);
    }

    public function langgananAktif()
    {
        return $this->hasOne(Langganan::class)->where('status', 'aktif')->latest();
    }

    public function alamatPengiriman()
    {
        return $this->hasMany(AlamatPengiriman::class);
    }

    public function alamatUtama()
    {
        return $this->hasOne(AlamatPengiriman::class)->where('is_primary', true);
    }

    public function preferensi()
    {
        return $this->hasOne(Preferensi::class);
    }

    // Tambahkan di dalam class User
    public function ratingsYangDiterima()
    {
        return $this->hasMany(Rating::class, 'rated_user_id');
    }

    public function rataRataRatingKurator()
    {
        return $this->ratingsYangDiterima()
            ->where('tipe', 'kurator')
            ->avg('rating') ?? 0;
    }

    public function rataRataRatingKurir()
    {
        return $this->ratingsYangDiterima()
            ->where('tipe', 'kurir')
            ->avg('rating') ?? 0;
    }

    public function totalRatingKurator()
    {
        return $this->ratingsYangDiterima()
            ->where('tipe', 'kurator')
            ->count();
    }

    public function totalRatingKurir()
    {
        return $this->ratingsYangDiterima()
            ->where('tipe', 'kurir')
            ->count();
    }

    public function boxKurasi()
    {
        return $this->hasMany(Box::class, 'kurator_id');
    }

    public function boxPengiriman()
    {
        return $this->hasMany(Box::class, 'kurir_id');
    }
}
