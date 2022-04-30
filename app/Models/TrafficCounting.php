<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrafficCounting extends Model
{
    use HasFactory;

    protected $table = "traffic_counting";

    protected $guarded = ['id'];
}
