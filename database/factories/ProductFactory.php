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

        $name = $this->faker->unique()->randomElement($medicalProducts);

        return [
            'category_id' => Category::inRandomOrder()->first()?->id,
            'name'        => $name,
            // generate slug based on name + random string to guarantee uniqueness
            'slug'        => Str::slug($name) . '-' . Str::random(6),
            'description' => $this->faker->randomElement($descriptions),
            'price'       => $this->faker->randomFloat(2, 50, 2000),
            'old_price'   => $this->faker->randomFloat(2, 60, 2500),
            'stock'       => $this->faker->numberBetween(0, 100),
            'type'        => $this->faker->randomElement(['normal', 'best_seller', 'new_arrival', 'popular', 'top_rated']),
        ];
    }
}
