<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Admin;
use App\Models\BrandAdmin;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Coupon;
use App\Models\UserWishlist;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->word();
        return [
            'name' => $name,
            'slug' =>Str::slug($name),
            'description' => fake()->paragraph(),
            'image' => 'https://picsum.photos/seed/' . Str::random(10) . '/640/480',
            'price' => $price = fake()->randomFloat(2, 50, 500),
            'discount_in_percentage' => $discount = fake()->numberBetween(0, 30),
            'total_price' => $price - ($price * $discount / 100),
            'quantity' => fake()->numberBetween(1, 100),
            'condition' => fake()->randomElement(['Default', 'New', 'Hot']),
            'status' => true,
            'category_id' => Category::factory(),
            'sub_category_id' => SubCategory::factory(),
            'brand_id' => Brand::factory(),
        ];
    }
}
