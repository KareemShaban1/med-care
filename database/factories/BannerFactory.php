<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Banner;

class BannerFactory extends Factory
{
    protected $model = Banner::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'type' => 'image',
            'url' => $this->faker->url,
            'status' => $this->faker->boolean(100), 
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Banner $banner) {
            // Attach a random placeholder image
            $banner->addMediaFromUrl('https://picsum.photos/1200/400?random=' . rand(1, 1000))
                   ->toMediaCollection('banners');
        });
    }
}
