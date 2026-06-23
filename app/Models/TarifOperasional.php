<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifOperasional extends Model
{
    protected $table = 'tarif_operasional';

    protected $fillable = ['kunci', 'nominal', 'keterangan'];

    public static function get(string $kunci): int
    {
        return static::where('kunci', $kunci)->value('nominal') ?? 0;
    }

}
