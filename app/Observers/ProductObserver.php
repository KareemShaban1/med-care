<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    //

    public function creating(Product $product){
        $product->slug = str()->slug($product->name);
    }

    public function updating(Product $product){
        $product->slug = str()->slug($product->name);
    }
}
