<?php

namespace App\Repository\Admin;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Repository\Admin\CategoryInterface;
use Illuminate\Http\Request;

class CategoryRepository implements CategoryRepositoryInterface
{
       /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();


        return view('backend.pages.categories.index', compact('categories'));
    }

    public function data()
    {
        $categories = Category::query();
        return datatables()->of($categories)
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
                $btn .= '<button onclick="editCategory(' . $item->id . ')" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></button>';
                $btn .= '<button onclick="deleteCategory(' . $item->id . ')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {
        try {
            Category::create($request->validated());

            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => __('Category created successfully'),
                ]);
            }

            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
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
    public function show($category)
    {
        if (request()->ajax()) {
            return response()->json($category);
        }
        return view('backend.pages.categories.show', compact('category'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update($request, $category)
    {

        try {
            $category->update($request->validated());

            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => __('Category updated successfully'),
                ]);
            }

            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function updateStatus($request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $request->status;
        $category->save();
        return response()->json([
            'status'  => 'success',
            'message' => __('Category status updated successfully'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($category)
    {
        $category->delete();
        if (request()->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => __('Category deleted successfully'),
            ]);
        }
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }

    public function trash()
    {
        return view('backend.pages.categories.trash');
    }
    
    public function trashData()
    {
        $categories = Category::onlyTrashed();
    
        return datatables()->of($categories)

            ->addColumn('status', function ($category) {
                return '<span class="badge bg-secondary">Trashed</span>';
            })
            ->addColumn('action', function ($category) {
                return '
                    <button class="btn btn-sm btn-success" onclick="restoreCategory('.$category->id.')">
                        <i class="mdi mdi-restore"></i> Restore
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="forceDeleteCategory('.$category->id.')">
                        <i class="mdi mdi-delete-forever"></i> Delete
                    </button>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('admin.categories.index')->with('success', 'Category restored successfully');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if (request()->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => __('Category deleted successfully'),
            ]);
        }
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }

}