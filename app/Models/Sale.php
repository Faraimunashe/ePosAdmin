<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'epos.sales';
    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(SaleItem::class, 'sale_id');
    }
}
