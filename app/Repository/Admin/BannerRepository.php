<?php

namespace App\Repository\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BannerRepository implements BannerRepositoryInterface
{
    /**
     * Display a listing of the banners.
     */
    public function index()
    {
        return [];
    }

    /**
     * Get banners data
     */
    public function data()
    {
        $banners = Banner::query();

        return DataTables::of($banners)
            ->editColumn('image', fn($item) => $this->bannerImage($item))
            ->editColumn('status', fn($item) => $this->bannerStatus($item))
            ->addColumn('action', fn($item) => $this->bannerActions($item))
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }

    /**
     * Store a newly created banner.
     */
    public function store($request)
    {
        return $this->saveBanner(new Banner(), $request, 'created');
    }

    /**
     * Display the banner.
     */
    public function show($id)
    {
        return Banner::findOrFail($id);
    }

    /**
     * Update banner.
     */
    public function update($request, $id)
    {
        $banner = Banner::findOrFail($id);
        return $this->saveBanner($banner, $request, 'updated');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus($request)
    {
        $banner = Banner::findOrFail($request->id);
        $banner->status = (bool)$request->status;
        $banner->save();

        return $this->jsonResponse('success', __('Banner status updated successfully'));
    }

    /**
     * Remove the specified banner from storage.
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return $this->jsonResponse('success', __('Banner deleted successfully'));
    }

    /**
     * Display a listing of the trashed banners.
     */
    public function trash()
    {
        return [];
    }

    /**
     * Get trashed banners data
     */
    public function trashData()
    {
        $banners = Banner::onlyTrashed();

        return DataTables::of($banners)
            ->addColumn('image', fn($item) => $item->image_url ? '<img src="'.$item->image_url.'" class="img-fluid rounded" style="max-height:50px;">' : '')
            ->addColumn('status', fn() => '<span class="badge bg-secondary">Trashed</span>')
            ->addColumn('action', fn($item) => $this->trashActions($item))
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }

    /**
     * Restore the specified banner from storage.
     */
    public function restore($id)
    {
        $banner = Banner::onlyTrashed()->findOrFail($id);
        $banner->restore();

        return redirect()->route('admin.banners.index')->with('success', __('Banner restored successfully'));
    }

    /**
     * Force delete the specified banner from storage.
     */
    public function forceDelete($id)
    {
        $banner = Banner::onlyTrashed()->findOrFail($id);
        $this->deleteMedia($banner);
        $banner->forceDelete();

        return $this->jsonResponse('success', __('Banner permanently deleted successfully'));
    }



    /** ---------------------- PRIVATE HELPERS ---------------------- */

    /**
     * Save the banner.
     * steps:
     * 1. fill the banner
     * 2. handle media
     * 3. save the banner
     */

    private function saveBanner(Banner $banner, $request, string $action)
    {
        try {
            $banner->fill($request->validated())->save();
            $this->handleMedia($banner, $request);

            if ($request->ajax()) {
                return $this->jsonResponse('success', __('Banner '.$action.' successfully'));
            }

            return redirect()->route('admin.banners.index')->with('success', __('Banner '.$action.' successfully'));
        } catch (\Throwable $e) {
            return $this->jsonResponse('error', $e->getMessage());
        }
    }

    /**
     * Handle the media.
     * steps:
     * 1. delete the media if exists
     * 2. add the media
     */
    private function handleMedia(Banner $banner, $request)
    {
        if ($request->hasFile('image')) {
            $this->deleteMedia($banner);
            $banner->addMedia($request->file('image'))->toMediaCollection('banners');
        }
    }

    /**
     * Delete the media.
     * steps:
     * 1. delete the media if exists
     */
    private function deleteMedia(Banner $banner)
    {
        if ($banner->hasMedia('banners')) {
            $banner->clearMediaCollection('banners');
        }
    }

    /**
     * Get the banner image.
     * steps:
     * 1. return the image if exists
     */
    private function bannerImage(Banner $item): string
    {
        return '<img src="' . $item->image_url . '" class="img-fluid" style="max-width:100px;">';
    }

    /**
     * Get the banner status.
     * steps:
     * 1. return the status if exists
     */
    private function bannerStatus(Banner $item): string
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

    /**
     * Get the banner actions.
     * steps:
     * 1. return the actions if exists
     */
    private function bannerActions(Banner $item): string
    {
        return <<<HTML
        <div class="d-flex gap-2">
            <button onclick="editBanner({$item->id})" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></button>
            <button onclick="deleteBanner({$item->id})" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
        </div>
        HTML;
    }

    private function trashActions(Banner $item): string
    {
        return <<<HTML
        <button class="btn btn-sm btn-success" onclick="restoreBanner({$item->id})">
            <i class="mdi mdi-restore"></i> Restore
        </button>
        <button class="btn btn-sm btn-danger" onclick="forceDeleteBanner({$item->id})">
            <i class="mdi mdi-delete-forever"></i> Delete
        </button>
        HTML;
    }

    /**
     * Get the json response.
     * steps:
     * 1. return the json response if ajax request
     * 2. return the redirect response if not ajax request
     */
    private function jsonResponse(string $status, string $message)
    {
        if (request()->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with($status, $message);
    }
}
