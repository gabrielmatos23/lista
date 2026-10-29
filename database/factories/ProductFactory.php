<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Product> */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'category' => fake()->randomElement(['Bolos', 'Doces', 'Salgados', 'Bebidas']),
            'price' => fake()->randomFloat(2, 5, 120),
            'stock' => fake()->numberBetween(8, 40),
            'minimum_stock' => 5,
        ];
    }
}
