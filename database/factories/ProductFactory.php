<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'       => $this->faker->unique()->sentence(),
            'slug'        => $this->faker->unique()->slug(),
            'description' => $this->faker->text(),
            'price'       => $this->faker->randomFloat(2, 0, 100),
            'image'       => $this->faker->imageUrl(450, 450),
            'quantity'    => $this->faker->numberBetween(1, 10),
        ];
    }
}
