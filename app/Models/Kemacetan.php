<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kemacetan extends Model
{
    use HasFactory;

    protected $table = "kemacetan";

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
