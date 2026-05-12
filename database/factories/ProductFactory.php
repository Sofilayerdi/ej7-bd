<?php
namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $price = fake()->randomFloat(2, 10, 5000);
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'name'        => ucfirst($name),
            'slug'        => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 99999),
            'description' => fake()->paragraph(),
            'price'       => $price,
            'sale_price'  => fake()->boolean(30) ? $price * 0.8 : null,
            'stock'       => fake()->numberBetween(0, 500),
            'sku'         => strtoupper(fake()->unique()->bothify('??-####-??')),
            'is_active'   => fake()->boolean(85),
        ];
    }
}