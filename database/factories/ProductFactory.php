<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductFactory extends Factory {
    protected $model = Product::class;

    public function definition(): array
    {
      
        $descriptions = [
            'High-quality and reliable medical device for daily use.',
            'Clinically tested and recommended by healthcare professionals.',
            'Compact, portable, and easy to use.',
            'Provides accurate readings with minimal effort.',
            'Manufactured with premium medical-grade materials.',
        ];

        return [
            'category_id' => Category::inRandomOrder()->first()?->id,
            'name' => $this->faker->words(2,true),
            // generate slug based on name + random string to guarantee uniqueness
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->randomElement($descriptions),
            'price'       => $this->faker->randomFloat(2, 50, 2000),
            'old_price'   => $this->faker->randomFloat(2, 60, 2500),
            'stock'       => $this->faker->numberBetween(0, 100),
            'type'        => $this->faker->randomElement(['normal', 'best_seller', 'new_arrival', 'popular', 'top_rated']),
        ];
    }
}
