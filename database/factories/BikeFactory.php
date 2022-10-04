<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Database\Factories\BikeFactory;

class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'idvelo' => $this->faker->id(),
            'idUser' => $this->faker->unique()->safeEmail(),
            'location_done_at' => now(),
            'location_description' => $this->faker->description(),
            'remember_token' => Str::random(10),
        ];
    }
}
