<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::create([
            'name'=>"admin",
            'email'=>"admin@admin.com",
            'password'=>bcrypt('12345678'),
        ]);

        // Brands
        Brand::factory(5)->create();

        // Categories + SubCategories
        Category::factory(3)->create()->each(function ($category) {
            SubCategory::factory(2)->create([
                'category_id' => $category->id,
            ]);
        });

        // Products
        Product::factory(3)->create();
        $this->call(RolePermissionSeeder::class);

        // Carts
        /*Cart::factory(10)->create()->each(function ($cart) {
            CartItem::factory(rand(1, 5))->create([
                'cart_id' => $cart->id,
            ]);
        });

        // Orders
        Order::factory(10)->create()->each(function ($order) {
            OrderDetail::factory()->create([
                'order_id' => $order->id,
            ]);

            OrderItem::factory(rand(1, 4))->create([
                'order_id' => $order->id,
            ]);
        });*/
    }
}
