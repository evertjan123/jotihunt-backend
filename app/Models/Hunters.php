<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class Hunters extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'driver',
        'code',
        'license_plate',
        'lat',
        'long',
        'location_send_at',
        'is_hunting',
        'is_live',
        'area_id'
    ];


    protected $table = 'hunters';

    public function area(){
        return $this->belongsTo(Area::class);
    }
}
