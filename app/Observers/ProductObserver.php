<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver extends GenericObserver
{
    //

    public function creating(Product $product){
        $product->slug = str()->slug($product->name);
    }

    public function updating(Product $product){
        $product->slug = str()->slug($product->name);
    }
}
