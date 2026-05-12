<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    public function definition(): array
    {
        $type = fake()->randomElement(['fixed', 'percentage']);
        return [
            'code'             => strtoupper(fake()->unique()->bothify('SAVE-####')),
            'type'             => $type,
            'value'            => $type === 'percentage'
                                    ? fake()->randomFloat(2, 5, 50)
                                    : fake()->randomFloat(2, 5, 200),
            'min_order_amount' => fake()->randomFloat(2, 0, 100),
            'max_uses'         => fake()->boolean(70) ? fake()->numberBetween(10, 500) : null,
            'used_count'       => fake()->numberBetween(0, 50),
            'expires_at'       => fake()->boolean(70) ? fake()->dateTimeBetween('now', '+1 year') : null,
            'is_active'        => fake()->boolean(80),
        ];
    }
}