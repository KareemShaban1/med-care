<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repository\Admin\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryRepositoryInterface $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        return $this->category->index();
    }

    public function data()
    {
        return $this->category->data();
    }

    public function store(StoreCategoryRequest $request)
    {
        return $this->category->store($request);
    }

    public function show(Category $category)
    {
        return $this->category->show($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        return $this->category->update($request, $category);
    }

    public function updateStatus(Request $request)
    {
        return $this->category->updateStatus($request);
    }

    public function destroy(Category $category)
    {
        return $this->category->destroy($category);
    }

    public function trash()
    {
        return $this->category->trash();
    }

    public function trashData()
    {
        return $this->category->trashData();
    }

    public function restore($id)
    {
        return $this->category->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->category->forceDelete($id);
    }

}
