<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'epos.items';
    public $timestamps = false;

    public function sale_items()
    {
        return $this->hasMany(SaleItem::class, 'item_id');
    }

}
