<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kemacetan extends Model
{
    use HasFactory;

    protected $table = "kemacetan";

    protected $guarded = ['id'];
}
