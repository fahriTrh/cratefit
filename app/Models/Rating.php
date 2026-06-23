<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'user_id',
        'rated_user_id',
        'box_id',
        'tipe',
        'rating',
        'komentar',
    ];

    public function pemberiRating()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function penerimRating()
    {
        return $this->belongsTo(User::class, 'rated_user_id');
    }

    public function box()
    {
        return $this->belongsTo(Box::class);
    }

}
