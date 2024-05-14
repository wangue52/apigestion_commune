<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlocFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Bloc::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'number_shop' => $this->faker->numberBetween(1, 100),
        ];
    }
}
