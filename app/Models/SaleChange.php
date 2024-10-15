<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleChange extends Model
{
    use HasFactory;

    protected $table = 'epos.sale_changes';
    public $timestamps = false;
}
