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
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'phone_number' => fake()->phoneNumber(),
            'address_one' => fake()->streetAddress(),
            'address_two' => fake()->optional()->secondaryAddress(),
            'postal_code' => fake()->postcode(),
            'order_id' => Order::factory(),
        ];
    }
}
