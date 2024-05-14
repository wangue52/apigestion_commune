<?php

namespace Database\Factories;

use App\Models\Bloc;
use App\Models\Store;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\store>
 * 
 */

class storeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['disponible', 'indisponible'];

        return [
            'name' => $this->faker->company,
            'matricule'=> $this->faker->unique->numerify(),
            'bloc_id' => Bloc::inRandomOrder()->first()->id,
            'city' => $this->faker->city,
            'district' => $this->faker->streetAddress,
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude,
            'status' => $this->faker->randomElement($statuses),
        ];
    }
}



   