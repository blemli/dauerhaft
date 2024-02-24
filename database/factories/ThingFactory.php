<?php

namespace Database\Factories;

use App\Models\Thing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ThingFactory extends Factory
{
    protected $model = Thing::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(),
            'buy_date' => Carbon::now(),
            'death_date' => Carbon::now(),
            'picture' => $this->faker->word(),
        ];
    }
}
