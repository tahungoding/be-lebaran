<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecelakaan extends Model
{
    use HasFactory;

    protected $table = "kecelakaan";

    protected $fillable = [
        'lokasi', 'ringkas_kejadian', 'detail_kejadian', 'file_pendukung', 'waktu', 'latitude', 'longitude'
    ];
}
