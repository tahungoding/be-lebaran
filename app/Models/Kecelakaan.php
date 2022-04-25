<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecelakaan extends Model
{
    use HasFactory;

    protected $table = "kecelakaan";

    protected $guarded = ['id'];

    public function pos()
    {
        return $this->belongsTo(Pos::class);
    }

    public function pos_gatur()
    {
        return $this->belongsTo(PosGatur::class);
    }
}
