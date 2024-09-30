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
        'death_date' => 'datetime'
    ];

    /* how long has this thing been alive */
    public function daysAlive(): int
    {
        /* if it's still alive, use today as the death date */
        if ($this->death_date === null) {
            return $this->buy_date->diffInDays(now());
        }
        return $this->death_date->diffInDays($this->buy_date);
    }

    public function getMonthsAliveAttribute(): int
    {
        return $this->daysAlive() / 30;
    }

    //alive
    public function getAliveAttribute(): bool
    {
        return $this->death_date === null;
    }


    /* how much did it cost per day during its livetime */
    public function getPricePerDayAttribute(): float
    {
        //handle if days alive is 0
        if ($this->daysAlive() === 0) {
            return 0;
            //todo: handle this case
        }
        return $this->price / $this->daysAlive();
    }

    public function markAsDead(): void
    {
        $this->death_date = now();
        $this->save();
    }
}
