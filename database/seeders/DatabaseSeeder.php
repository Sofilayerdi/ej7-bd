<?php
namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuarios (500)
        $this->command->info('Seeding users...');
        User::factory(500)->create();
        $userIds = User::pluck('id')->toArray();

        // 2. Categorías (20)
        $this->command->info('Seeding categories...');
        Category::factory(20)->create();
        $categoryIds = Category::pluck('id')->toArray();

        // 3. Cupones (50)
        $this->command->info('Seeding coupons...');
        Coupon::factory(50)->create();
        $couponIds = Coupon::pluck('id')->toArray();

        // 4. Productos (1,000)
        $this->command->info('Seeding products...');
        Product::factory(1000)->create(fn() => [
            'category_id' => fake()->randomElement($categoryIds),
        ]);
        $productIds = Product::pluck('id')->toArray();

        // 5. Imágenes de productos (3,000)
        $this->command->info('Seeding product images...');
        ProductImage::factory(3000)->create(fn() => [
            'product_id' => fake()->randomElement($productIds),
        ]);

        // 6. Direcciones (1,500)
        $this->command->info('Seeding addresses...');
        Address::factory(1500)->create(fn() => [
            'user_id' => fake()->randomElement($userIds),
        ]);
        $addressIds = Address::pluck('id')->toArray();

        // 7. Órdenes (2,000)
        $this->command->info('Seeding orders...');
        Order::factory(2000)->create(fn() => [
            'user_id'    => fake()->randomElement($userIds),
            'address_id' => fake()->randomElement($addressIds),
            'coupon_id'  => fake()->boolean(25) ? fake()->randomElement($couponIds) : null,
        ]);
        $orderIds = Order::pluck('id')->toArray();

        // 8. Items de órdenes (4,000)
        $this->command->info('Seeding order items...');
        $products = Product::select('id', 'price', 'sale_price')->get()->keyBy('id');
        foreach (range(1, 4000) as $_) {
            $product   = $products->random();
            $quantity  = fake()->numberBetween(1, 10);
            $unitPrice = $product->sale_price ?? $product->price;
            OrderItem::create([
                'order_id'   => fake()->randomElement($orderIds),
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'unit_price' => $unitPrice,
                'subtotal'   => $unitPrice * $quantity,
            ]);
        }

        // 9. Reseñas (2,000)
        $this->command->info('Seeding reviews...');
        Review::factory(2000)->create(fn() => [
            'user_id'    => fake()->randomElement($userIds),
            'product_id' => fake()->randomElement($productIds),
        ]);

        // 10. Pagos (1,800)
        $this->command->info('Seeding payments...');
        $orders = Order::select('id', 'total')->get()->keyBy('id');
        $usedOrderIds = [];
        foreach ($orderIds as $orderId) {
            if (count($usedOrderIds) >= 1800) break;
            $usedOrderIds[] = $orderId;
            Payment::create([
                'order_id'       => $orderId,
                'method'         => fake()->randomElement(['credit_card','debit_card','paypal','bank_transfer']),
                'status'         => fake()->randomElement(['pending','completed','failed','refunded']),
                'amount'         => $orders[$orderId]->total,
                'transaction_id' => strtoupper(fake()->unique()->bothify('TXN-########')),
            ]);
        }

        $this->command->info('Done! Database seeded successfully.');
    }
}