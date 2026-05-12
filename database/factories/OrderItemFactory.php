<?php
namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $product   = Product::inRandomOrder()->first();
        $quantity  = fake()->numberBetween(1, 10);
        $unitPrice = $product->sale_price ?? $product->price;
        return [
            'order_id'   => Order::inRandomOrder()->first()->id,
            'product_id' => $product->id,
            'quantity'   => $quantity,
            'unit_price' => $unitPrice,
            'subtotal'   => $unitPrice * $quantity,
        ];
    }
}