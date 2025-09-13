<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver extends GenericObserver
{
    //
    public function creating(Category $category)
    {
        $category->slug = str()->slug($category->name);
    }

    public function updating(Category $category)
    {
        $category->slug = str()->slug($category->name);
    }
    
}
