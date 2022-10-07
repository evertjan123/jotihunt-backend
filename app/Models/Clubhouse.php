<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clubhouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'accomodation',
        'street',
        'housenumber',
        'housenumber_addition',
        'postcode',
        'lat',
        'long',
        'photo_assignment_points'
    ];

    protected $table = 'clubhouses';

}
