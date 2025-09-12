<?php

namespace App\Repository\Admin;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repository\Admin\ProductInterface;
use Illuminate\Http\Request;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return view('backend.pages.products.index', compact('products'));
    }

    public function data()
    {
        $products = Product::with('category');
        return datatables()->of($products)
            ->addColumn('category', function ($item) {
                return $item->category->name ?? '';
            })
            ->addColumn('image', function ($item) {
                return '<img src="' . $item->main_image_url . '" alt="" class="img-fluid" style="width: 100px;">';
            })
            ->editColumn('status', function ($item) {
                $checked = $item->status ? 'checked' : '';
                return '
                <div class="form-check form-switch mt-2">
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" class="form-check-input toggle-boolean" 
                           data-id="' . $item->id . '" 
                           data-field="status" 
                           id="status-' . $item->id . '" 
                           name="status" value="1" ' . $checked . '>
                </div>';
            })
            ->addColumn('action', function ($item) {
                $btn = '<div class="d-flex gap-2">';
                $btn .= '<a href="' . route('admin.products.edit', $item->id) . '" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>';
                $btn .= '<button onclick="deleteProduct(' . $item->id . ')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['status', 'action', 'image'])
            ->make(true);
    }


    public function create()
    {
        $categories = Category::all();
        return view('backend.pages.products.create', compact('categories'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {
        try {
            $product = Product::create($request->validated());

            // Main image
            if ($request->hasFile('image')) {
                $product->addMedia($request->file('image'))->toMediaCollection('products');
            }

            // Gallery images
            if ($request->hasFile('gallery')) {
                // delete old gallery first
                $product->clearMediaCollection('products_gallery');

                foreach ($request->file('gallery') as $image) {
                    $product->addMedia($image)->toMediaCollection('products_gallery');
                }
            }

            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => __('Product created successfully'),
                ]);
            }

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($product)
    {
        if (request()->ajax()) {
            return response()->json($product);
        }
        return view('backend.pages.products.show', compact('product'));
    }

    public function edit($product)
    {
        $categories = Category::all();
        return view('backend.pages.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, $product)
    {

        try {
            $product->update($request->validated());


            // ✅ Image update
            if ($request->hasFile('image')) {
                $product->clearMediaCollection('products');
                $product->addMedia($request->file('image'))->toMediaCollection('products');
            }

            // ✅ Gallery update
            if ($request->hasFile('gallery')) {
                $product->clearMediaCollection('products_gallery');
                foreach ($request->file('gallery') as $image) {
                    $product->addMedia($image)->toMediaCollection('products_gallery');
                }
            }


            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => __('Product updated successfully'),
                ]);
            }

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function updateStatus($request)
    {
        $product = Product::findOrFail($request->id);
        $product->status = $request->status;
        $product->save();
        return response()->json([
            'status'  => 'success',
            'message' => __('Product status updated successfully'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product)
    {
        $product->delete();
        if (request()->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => __('Product deleted successfully'),
            ]);
        }
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }

    public function trash()
    {
        return view('backend.pages.products.trash');
    }
    
    public function trashData()
    {
        $products = Product::onlyTrashed();
    
        return datatables()->of($products)

            ->addColumn('status', function ($product) {
                return '<span class="badge bg-secondary">Trashed</span>';
            })
            ->addColumn('action', function ($product) {
                return '
                    <button class="btn btn-sm btn-success" onclick="restoreProduct('.$product->id.')">
                        <i class="mdi mdi-restore"></i> Restore
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="forceDeleteProduct('.$product->id.')">
                        <i class="mdi mdi-delete-forever"></i> Delete
                    </button>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('admin.products.index')->with('success', 'Product restored successfully');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        if (request()->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => __('Product deleted successfully'),
            ]);
        }
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }

}
