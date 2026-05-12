<?php

//CONSULTAS ELOQUENT 

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

// CONSULTA 1 

$productosBaratos = Product::with('category')
    ->where('is_active', true)
    ->where('price', '<', 500)
    ->orderBy('price', 'asc')
    ->get();

echo "=== CONSULTA 1: Productos activos menores a Q500 ===\n";
foreach ($productosBaratos as $p) {
    echo "  [{$p->category->name}] {$p->name} — Q{$p->price}\n";
}
echo "\n";

// CONSULTA 2
$ordenesGrandes = Order::with('user')
    ->where('status', 'delivered')
    ->where('total', '>', 1000)
    ->orderBy('total', 'desc')
    ->get();

echo "=== CONSULTA 2: Órdenes entregadas mayores a Q1,000 ===\n";
foreach ($ordenesGrandes as $o) {
    echo "  Orden #{$o->id} — {$o->user->name} — Q{$o->total}\n";
}
echo "\n";


// CONSULTA 3

$ordenes = Order::with(['items.product', 'user', 'payment'])
    ->where('status', 'processing')
    ->orderBy('created_at', 'desc')
    ->take(10)
    ->get();

echo "=== CONSULTA 4 (EAGER LOADING): Últimas 10 órdenes en procesamiento ===\n";
foreach ($ordenes as $o) {
    $itemCount = $o->items->count();
    $payStatus = $o->payment ? $o->payment->status : 'sin pago';
    echo "  Orden #{$o->id} — {$o->user->name} — {$itemCount} items — Pago: {$payStatus}\n";
    foreach ($o->items as $item) {
        echo "      └ {$item->product->name} x{$item->quantity} — Q{$item->subtotal}\n";
    }
}
echo "\n";

// CONSULTA 4

$usuariosDestacados = User::with(['reviews' => function ($q) {
        $q->where('is_approved', true)->where('rating', '>=', 4);
    }])
    ->whereHas('reviews', function ($q) {
        $q->where('is_approved', true)->where('rating', '>=', 4);
    })
    ->orderBy('name', 'asc')
    ->take(10)
    ->get();

echo "=== CONSULTA 5: Usuarios con reseñas aprobadas de rating >= 4 ===\n";
foreach ($usuariosDestacados as $u) {
    echo "  {$u->name} — {$u->reviews->count()} reseñas destacadas\n";
}
echo "\n";

// CONSULTA 5

$resenasTop = Review::with(['product', 'user'])
    ->where('is_approved', true)
    ->where('rating', 5)
    ->orderBy('created_at', 'desc')
    ->take(10)
    ->get();

echo "=== CONSULTA 6: Reseñas con rating perfecto (5 estrellas) ===\n";
foreach ($resenasTop as $r) {
    echo "  {$r->user->name} sobre \"{$r->product->name}\" — {$r->rating}★\n";
}
echo "\n";