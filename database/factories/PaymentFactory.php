<?php
namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        $order = Order::inRandomOrder()->first();
        return [
            'order_id'       => $order->id,
            'method'         => fake()->randomElement(['credit_card','debit_card','paypal','bank_transfer']),
            'status'         => fake()->randomElement(['pending','completed','failed','refunded']),
            'amount'         => $order->total,
            'transaction_id' => strtoupper(fake()->unique()->bothify('TXN-########')),
        ];
    }
}