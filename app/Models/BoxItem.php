<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxItem extends Model
{
    protected $table = 'box_items';

    protected $fillable = [
        'box_id',
        'item_id',
        'urutan',
    ];

    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }

    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}
