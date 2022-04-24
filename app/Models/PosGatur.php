<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosGatur extends Model
{
    use HasFactory;

    protected $table = "pos_gatur";

    protected $fillable = [
        'nama', 'latitude', 'longitude'
    ];
}
