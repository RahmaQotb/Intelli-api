<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        $category = Category::factory()->create();
        
        $subCategory = SubCategory::factory()->create([
            'category_id' => $category->id
        ]);
        
        $name = fake()->unique()->word();
        $price = fake()->randomFloat(2, 50, 500);
        $discount = fake()->numberBetween(0, 30);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'image' => 'https://picsum.photos/seed/' . Str::random(10) . '/640/480',
            'price' => $price,
            'discount_in_percentage' => $discount,
            'total_price' => $price - ($price * $discount / 100),
            'quantity' => fake()->numberBetween(1, 100),
            'condition' => fake()->randomElement(['Default', 'New', 'Hot']),
            'status' => true,
            'category_id' => $category->id,    
            'sub_category_id' => $subCategory->id, 
            'brand_id' => Brand::factory(),
        ];
    }
}
