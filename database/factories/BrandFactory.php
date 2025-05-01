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
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company();
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'logo' => 'https://picsum.photos/seed/' . Str::random(10) . '/640/480',
            'cover' =>'https://picsum.photos/seed/' . Str::random(10) . '/640/480',
            'status' => fake()->randomElement([true,false]),
            'organization_license' =>'https://picsum.photos/seed/' . Str::random(10) . '/640/480',
            'commercial_registry_extract' => 'https://picsum.photos/seed/' . Str::random(10) . '/640/480',
            'tax_registry' => 'https://picsum.photos/seed/' . Str::random(10) . '/640/480',
        ];
    }
}
