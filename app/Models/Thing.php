<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thing extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'buy_date',
        'death_date',
        'picture',
    ];

    protected $casts = [
        'buy_date' => 'datetime',
        'death_date' => 'datetime',
    ];
}
