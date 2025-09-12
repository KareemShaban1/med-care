<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Support\Facades\Storage;

class ProductFactory extends Factory {
    protected $model = Product::class;

    public function definition() {
        return [
            'category_id' => Category::inRandomOrder()->first()?->id,
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 500),
            'old_price' => $this->faker->randomFloat(2, 10, 500),
            'stock' => $this->faker->numberBetween(0, 50),
            'type' => $this->faker->randomElement(['normal','best_seller','new_arrival','popular','top_rated']),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            // Add main image
            $product->addMediaFromUrl('https://picsum.photos/600/400?random=' . rand(1, 1000))
                    ->toMediaCollection('products');

            // Add gallery images (1-5)
            $count = rand(1, 5);
            for ($i = 0; $i < $count; $i++) {
                $product->addMediaFromUrl('https://picsum.photos/600/400?random=' . rand(1001, 2000))
                        ->toMediaCollection('products_gallery');
            }
        });
    }
}
