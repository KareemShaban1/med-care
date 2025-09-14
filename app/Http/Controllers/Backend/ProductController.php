<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repository\Admin\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function index()
    {
        return $this->productRepo->index();
    }

    public function data()
    {
        return $this->productRepo->data();
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        return view('backend.pages.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        return $this->productRepo->store($request);
    }

    public function show($id)
    {
        $product = $this->productRepo->show($id);
        return request()->ajax()
            ? response()->json($product)
            : view('backend.pages.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = $this->productRepo->edit($id);
        $categories = Category::select('id', 'name')->get();
        return view('backend.pages.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        return $this->productRepo->update($request, $id);
    }

    public function updateStatus(Request $request)
    {
        return $this->productRepo->updateStatus($request);
    }

    public function destroy($id)
    {
        return $this->productRepo->destroy($id);
    }

    public function trash()
    {
        return $this->productRepo->trash();
    }

    public function trashData()
    {
        return $this->productRepo->trashData();
    }

    public function restore($id)
    {
        return $this->productRepo->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->productRepo->forceDelete($id);
    }
}
