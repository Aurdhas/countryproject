<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries'; // Nom de la table

    protected $fillable = [
        'name',
        'population',
        'region',
        'capital',
        'flag',
        'languages',
        'currencies',
    ];

    protected $casts = [
        'languages' => 'array',
        'currencies' => 'array',
    ];
}
