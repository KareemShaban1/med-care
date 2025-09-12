<?php

namespace App\Repository\Admin;

use App\Models\Banner;

class BannerRepository implements BannerRepositoryInterface
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();


        return view('backend.pages.banners.index', compact('banners'));
    }

    public function data()
    {
        $banners = Banner::query();
        return datatables()->of($banners)
            ->editColumn('image', function ($item) {
                return '<img src="' . $item->getImageUrlAttribute() . '" class="img-fluid" style="max-width: 100px;">';
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
                $btn .= '<button onclick="editBanner(' . $item->id . ')" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></button>';
                $btn .= '<button onclick="deleteBanner(' . $item->id . ')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['status', 'action', 'image'])
            ->make(true);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {
        try {
            $banner = Banner::create($request->validated());

            if ($request->hasFile('image')) {
                $banner->addMedia($request->file('image'))->toMediaCollection('banners');
            }

            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => __('Banner created successfully'),
                ]);
            }

            return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully');
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
    public function show($banner)
    {
        return response()->json([
            'id' => $banner->id,
            'title' => $banner->title,
            'url' => $banner->url,
            'type' => $banner->type,
            'status' => $banner->status,
            'image' => $banner->image_url ? $banner->image_url : null,
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update($request, $banner)
    {

        try {
            $banner->update($request->validated());

            if ($request->hasFile('image')) {
                $banner->clearMediaCollection('banners');
                $banner->addMedia($request->file('image'))->toMediaCollection('banners');
            }

            if ($request->ajax()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => __('Banner updated successfully'),
                ]);
            }

            return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully');
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function updateStatus($request)
    {
        $banner = Banner::findOrFail($request->id);
        $banner->status = $request->status;
        $banner->save();
        return response()->json([
            'status'  => 'success',
            'message' => __('Banner status updated successfully'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($banner)
    {
        $banner->delete();
        if (request()->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => __('banner deleted successfully'),
            ]);
        }
        return redirect()->route('admin.banners.index')->with('success', 'banner deleted successfully');
    }
    public function trash()
    {
        return view('backend.pages.banners.trash');
    }
    
    public function trashData()
    {
        $banners = Banner::onlyTrashed();
    
        return datatables()->of($banners)
            ->addColumn('image', function ($banner) {
                return $banner->image_url 
                    ? '<img src="'.$banner->image_url.'" class="img-fluid rounded" style="max-height:50px;">'
                    : '';
            })
            ->addColumn('status', function ($banner) {
                return '<span class="badge bg-secondary">Trashed</span>';
            })
            ->addColumn('action', function ($banner) {
                return '
                    <button class="btn btn-sm btn-success" onclick="restoreBanner('.$banner->id.')">
                        <i class="mdi mdi-restore"></i> Restore
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="forceDeleteBanner('.$banner->id.')">
                        <i class="mdi mdi-delete-forever"></i> Delete
                    </button>
                ';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }
    

    public function restore($id)
    {
        $banner = Banner::onlyTrashed()->findOrFail($id);
        $banner->restore();
        return redirect()->route('admin.banners.index')->with('success', 'Banner restored successfully');
    }

    public function forceDelete($id)
    {
        $banner = Banner::onlyTrashed()->findOrFail($id);
        $banner->clearMediaCollection('banners');
        $banner->forceDelete();

        if (request()->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => __('Banner deleted successfully'),
            ]);
        }
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully');
    }
}
