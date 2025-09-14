<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use App\Repository\Admin\BannerRepositoryInterface;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    protected $bannerRepo;

    public function __construct(BannerRepositoryInterface $bannerRepo)
    {
        $this->bannerRepo = $bannerRepo;
    }

    public function index()
    {
        return view('backend.pages.banners.index');
    }

    public function data()
    {
        return $this->bannerRepo->data();
    }

    public function store(StoreBannerRequest $request)
    {
        return $this->bannerRepo->store($request);
    }

    public function show($id)
    {
        $banner = $this->bannerRepo->show($id);
        return request()->ajax()
            ? response()->json($banner)
            : view('backend.pages.banners.show', compact('banner'));
    }

    public function update(UpdateBannerRequest $request, $id)
    {
        return $this->bannerRepo->update($request, $id);
    }

    public function updateStatus(Request $request)
    {
        return $this->bannerRepo->updateStatus($request);
    }

    public function destroy($id)
    {
        return $this->bannerRepo->destroy($id);
    }

    public function trash()
    {
        return view('backend.pages.banners.trash');
    }

    public function trashData()
    {
        return $this->bannerRepo->trashData();
    }

    public function restore($id)
    {
        return $this->bannerRepo->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->bannerRepo->forceDelete($id);
    }
}
