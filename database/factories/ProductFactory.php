<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Support\Facades\Storage;

class ProductFactory extends Factory {
    protected $model = Product::class;

    public function definition(): array
    {
        $medicalProducts = [
            'Digital Thermometer',
            'Blood Pressure Monitor',
            'Glucose Meter',
            'Surgical Mask Pack',
            'Hand Sanitizer Gel',
            'Vitamin C Tablets',
            'Omega 3 Fish Oil',
            'Disposable Gloves Box',
            'Stethoscope',
            'Nebulizer Machine',
            'First Aid Kit',
            'Infrared Thermometer',
            'Antiseptic Wipes',
            'Surgical Scissors',
            'Face Shield',
        ];

        $descriptions = [
            'High-quality and reliable medical device for daily use.',
            'Clinically tested and recommended by healthcare professionals.',
            'Compact, portable, and easy to use.',
            'Provides accurate readings with minimal effort.',
            'Manufactured with premium medical-grade materials.',
        ];

        return [
            'category_id' => Category::inRandomOrder()->first()?->id,
            'name'        => $this->faker->randomElement($medicalProducts),
            'slug'        => $this->faker->unique()->slug,
            'description' => $this->faker->randomElement($descriptions),
            'price'       => $this->faker->randomFloat(2, 50, 2000),
            'old_price'   => $this->faker->randomFloat(2, 60, 2500),
            'stock'       => $this->faker->numberBetween(0, 100),
            'type'        => $this->faker->randomElement(['normal', 'best_seller', 'new_arrival', 'popular', 'top_rated']),
        ];
    }

    // public function configure()
    // {
    //     return $this->afterCreating(function (Product $product) {
    //         // Add main image
    //         $product->addMediaFromUrl('https://picsum.photos/600/400?random=' . rand(1, 1000))
    //                 ->toMediaCollection('products');

    //         // Add gallery images (1-5)
    //         $count = rand(1, 5);
    //         for ($i = 0; $i < $count; $i++) {
    //             $product->addMediaFromUrl('https://picsum.photos/600/400?random=' . rand(1001, 2000))
    //                     ->toMediaCollection('products_gallery');
    //         }
    //     });
    // }
}
