<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hunts extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'time',
        'path_to_photo',
        'hunter_id',
        'area_id'
    ];

    protected $table = 'hunts';

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function hunter(){
        return $this->belongsTo(Hunter::class);
    }
}
