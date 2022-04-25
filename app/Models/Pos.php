<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    use HasFactory;

    protected $table = "pos";
    protected $guarded = ['id'];

    public function medicineType() 
    {
      return $this->belongsTo(District::class, 'id');
   }
}
