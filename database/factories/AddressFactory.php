<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'     => User::inRandomOrder()->first()->id,
            'line1'       => fake()->streetAddress(),
            'line2'       => fake()->boolean(40) ? fake()->secondaryAddress() : null,
            'city'        => fake()->city(),
            'state'       => fake()->state(),
            'postal_code' => fake()->postcode(),
            'country'     => fake()->randomElement(['Guatemala', 'México', 'Honduras', 'El Salvador']),
            'is_default'  => false,
        ];
    }
}