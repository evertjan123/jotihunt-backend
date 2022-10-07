<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hunters extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver',
        'license_plate',
        'lat',
        'long',
        'location_send_at',
        'is_hunting',
        'is_live'
    ];


    protected $table = 'hunters';
}
