<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'old_price',
        'price',
        'stock',
        'category_id',
        'featured',
        'status',
        'type',
    ];

    // cast
    protected $cast = [
        'status'=>'boolean',
        'featured'=>'boolean'
    ];

    // appends
    protected $appends = ['main_image_url', 'images_urls'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getMainImageUrlAttribute()
    {
        $media = $this->getFirstMedia('products');
        return $media ? $media->getUrl() : 'https://placehold.co/350x263';
    }

    public function getImagesUrlsAttribute()
    {
        return $this->getMedia('products_gallery')
            ->map(fn($media) => $media->getUrl())
            ->toArray();
    }
}
