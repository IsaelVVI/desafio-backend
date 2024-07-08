<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'price',
        'color',
        'mileage',
        'plate',
        'city',
        'created',
        'view',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
