<?php
namespace Database\Factories;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 20, 3000);
        $discount = fake()->boolean(30) ? fake()->randomFloat(2, 5, $subtotal * 0.3) : 0;
        return [
            'user_id'    => User::inRandomOrder()->first()->id,
            'address_id' => Address::inRandomOrder()->first()->id,
            'coupon_id'  => fake()->boolean(25) ? Coupon::inRandomOrder()->first()->id : null,
            'status'     => fake()->randomElement(['pending','processing','shipped','delivered','cancelled']),
            'subtotal'   => $subtotal,
            'discount'   => $discount,
            'total'      => $subtotal - $discount,
        ];
    }
}