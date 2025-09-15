<?php

namespace App\Repository\Admin;

use App\Models\Product;
use App\Models\Category;

class ProductRepository implements ProductRepositoryInterface
{
    /** ---------------------- PUBLIC METHODS ---------------------- */

    /**
     * Display a listing of the products.
     */
    public function index()
    {
        return view('backend.pages.products.index');
    }

    /**
     * Get the products data.
     */
    public function data()
    {
        $products = Product::with('category');

        return datatables()->of($products)
            ->addColumn('category', fn($item) => $item->category->name ?? '')
            ->addColumn('image', fn($item) => $this->productImage($item))
            ->editColumn('status', fn($item) => $this->productStatus($item))
            ->addColumn('action', fn($item) => $this->productActions($item))
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return [];
    }

    public function store($request)
    {
        return $this->saveProduct(new Product(), $request, 'created');
    }

    public function show($id)
    {

        return Product::findOrFail($id);
    }

    public function edit($id)
    {
        return Product::findOrFail($id);
    }

    public function update($request, $id)
    {
        $product = Product::findOrFail($id);
        return $this->saveProduct($product, $request, 'updated');
    }

    public function updateStatus($request)
    {
        $product = Product::findOrFail($request->id);
        $product->status = (bool)$request->status;
        $product->save();

        return $this->jsonResponse('success', __('Product status updated successfully'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return $this->jsonResponse('success', __('Product deleted successfully'));
    }

    public function trash()
    {
        return view('backend.pages.products.trash');
    }

    public function trashData()
    {
        $products = Product::onlyTrashed();

        return datatables()->of($products)
            ->addColumn('status', fn() => '<span class="badge bg-secondary">Trashed</span>')
            ->addColumn('action', fn($item) => $this->trashActions($item))
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index')->with('success', __('Product restored successfully'));
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $this->deleteMedia($product);
        $product->forceDelete();

        return $this->jsonResponse('success', __('Product permanently deleted successfully'));
    }

    /** ---------------------- PRIVATE HELPERS ---------------------- */

    private function saveProduct(Product $product, $request, string $action)
    {
        try {
            $product->fill($request->validated())->save();

            $this->handleMedia($product, $request);

            if ($request->ajax()) {
                return $this->jsonResponse('success', __('Product '.$action.' successfully'));
            }

            return redirect()->route('admin.products.index')->with('success', __('Product '.$action.' successfully'));
        } catch (\Throwable $e) {
            return $this->jsonResponse('error', $e->getMessage());
        }
    }

    private function handleMedia(Product $product, $request)
    {
        // Main image
        if ($request->hasFile('image')) {
            $product->clearMediaCollection('products');
            $product->addMedia($request->file('image'))->toMediaCollection('products');
        }

        // Gallery images
        if ($request->hasFile('gallery')) {
            $product->clearMediaCollection('products_gallery');
            foreach ($request->file('gallery') as $image) {
                $product->addMedia($image)->toMediaCollection('products_gallery');
            }
        }
    }

    private function deleteMedia(Product $product)
    {
        $product->clearMediaCollection('products');
        $product->clearMediaCollection('products_gallery');
    }

    private function productImage(Product $item): string
    {
        return '<img src="' . $item->main_image_url . '" class="img-fluid" style="max-width:100px;">';
    }

    private function productStatus(Product $item): string
    {
        $checked = $item->status ? 'checked' : '';
        return <<<HTML
            <div class="form-check form-switch mt-2">
                <input type="hidden" name="status" value="0">
                <input type="checkbox" class="form-check-input toggle-boolean"
                       data-id="{$item->id}" data-field="status" id="status-{$item->id}"
                       name="status" value="1" {$checked}>
            </div>
        HTML;
    }

    private function productActions(Product $item): string
    {
        return <<<HTML
        <div class="d-flex gap-2">
            <a href="{$this->editRoute($item)}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
            <button onclick="deleteProduct({$item->id})" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
        </div>
        HTML;
    }

    private function trashActions(Product $item): string
    {
        return <<<HTML
        <button class="btn btn-sm btn-success" onclick="restoreProduct({$item->id})">
            <i class="mdi mdi-restore"></i> {{__('Restore')}}
        </button>
        <button class="btn btn-sm btn-danger" onclick="forceDeleteProduct({$item->id})">
            <i class="mdi mdi-delete-forever"></i> {{__('Delete')}}
        </button>
        HTML;
    }

    private function editRoute(Product $item): string
    {
        return route('admin.products.edit', $item->id);
    }

    private function jsonResponse(string $status, string $message)
    {
        if (request()->ajax()) {
            return response()->json(['status' => $status, 'message' => $message]);
        }

        return redirect()->back()->with($status, $message);
    }
}
