<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleCash extends Model
{
    use HasFactory;

    protected $table = 'epos.sale_cash';
    public $timestamps = false;
}
