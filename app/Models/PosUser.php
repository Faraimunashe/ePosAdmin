<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosUser extends Model
{
    use HasFactory;

    protected $table = 'epos.users';
    public $timestamps = false;
}
