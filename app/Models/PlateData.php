<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlateData extends Model
{
    protected $table = 'plate_data';

    protected $fillable = [
        'plate_number',
        'state',
        'vin',
        'fuel',
        'make',
        'name',
        'trim',
        'year',
        'color_name',
        'color_abbreviation',
        'model',
        'style',
        'engine',
        'drive_type',
        'transmission',
    ];

    protected $casts = [
        'year' => 'integer',
    ];
}
