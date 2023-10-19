<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hunts extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'hunter_id',
        'area_id'
    ];

    protected $table = 'hunts';

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function hunters(){
        return $this->belongsTo(Hunters::class);
    }
}
