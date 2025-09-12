<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Banner extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;
    protected $fillable = [
        'title',
        'type',
        'url',
        'status',
    ];

    public $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        $media = $this->getFirstMedia('banners');
        return $media ? $media->getUrl() : 'https://placehold.co/350x263';
    }
}
