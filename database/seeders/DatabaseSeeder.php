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
        User::factory(500)->create();

        // 2. Categorías (20)
        Category::factory(20)->create();

        // 3. Cupones (50)
        Coupon::factory(50)->create();

        // 4. Productos (1,000)
        Product::factory(1000)->create();

        // 5. Imágenes de productos (3,000)
        ProductImage::factory(3000)->create();

        // 6. Direcciones (1,500)
        Address::factory(1500)->create();

        // 7. Órdenes (2,000)
        Order::factory(2000)->create();

        // 8. Items de órdenes (4,000) → supera 10,000 total
        OrderItem::factory(4000)->create();

        // 9. Reseñas (2,000)
        Review::factory(2000)->create();

        // 10. Pagos (1,800)
        Payment::factory(1800)->create();

        // Total: ~19,870 registros
    }
}