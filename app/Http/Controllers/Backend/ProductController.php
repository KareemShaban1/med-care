<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Controllers\Controller;
use App\Repository\Admin\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   protected $product;

   public function __construct(ProductRepositoryInterface $product)
   {
       $this->product = $product;
   }

   public function index()
   {
       return $this->product->index();
   }

   public function data()
   {
       return $this->product->data();
   }

   public function create()
   {
       return $this->product->create();
   }

   public function store(StoreProductRequest $request)
   {
       return $this->product->store($request);
   }

   public function show(Product $product)
   {
       return $this->product->show($product);
   }

   public function edit(Product $product)
   {
       return $this->product->edit($product);
   }

   public function update(UpdateProductRequest $request, Product $product)
   {
       return $this->product->update($request, $product);
   }

   public function updateStatus(Request $request)
   {
       return $this->product->updateStatus($request);
   }

   public function destroy(Product $product)
   {
       return $this->product->destroy($product);
   }

   public function trash()
   {
       return $this->product->trash();
   }

   public function trashData()
   {
       return $this->product->trashData();
   }

   public function restore($id)
   {
       return $this->product->restore($id);
   }

   public function forceDelete($id)
   {
       return $this->product->forceDelete($id);
   }

}
