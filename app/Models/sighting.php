<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\Hunters;



class sighting extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'lat',
        'long',
        'optional_name',
        'hunter_id',
        'area_id'
    ];

    protected $table = 'sightings';

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function hunters(){
        return $this->belongsTo(Hunters::class);
    }
}
