<?php
namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'url'        => 'https://picsum.photos/seed/' . fake()->unique()->numberBetween(1,99999) . '/640/480',
            'is_primary' => false,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}