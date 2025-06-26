<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@tokobunga.test',
            'role' => 'admin',
            'address' => 'Jl. Mawar No. 1, Jakarta',
            'phone' => '081234567890',
        ]);

        // Customer user
        $customer = User::factory()->create([
            'name' => 'Pelanggan',
            'email' => 'customer@tokobunga.test',
            'role' => 'customer',
            'address' => 'Jl. Melati No. 2, Bandung',
            'phone' => '082345678901',
        ]);

        // Dummy products
        Product::factory(10)->create();

        // Dummy carts for customer
        $cart = Cart::factory()->create(['user_id' => $customer->id]);
        $products = Product::inRandomOrder()->take(3)->get();
        foreach ($products as $product) {
            CartItem::factory()->create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 5),
            ]);
        }

        // Dummy orders for customer
        for ($i = 0; $i < 3; $i++) {
            $order = Order::factory()->create([
                'user_id' => $customer->id,
                'total_amount' => rand(100000, 500000),
                'status' => 'completed',
                'shipping_address' => $customer->address,
                'recipient_name' => $customer->name,
                'recipient_phone' => $customer->phone,
            ]);
            foreach (Product::inRandomOrder()->take(2)->get() as $product) {
                OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                    'price' => $product->price,
                ]);
            }
        }
    }
}
