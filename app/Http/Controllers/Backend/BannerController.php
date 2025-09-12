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
    
    protected $banner;

    public function __construct(BannerRepositoryInterface $banner)
    {
        $this->banner = $banner;
    }

    public function index()
    {
        return $this->banner->index();
    }

    public function data()
    {
        return $this->banner->data();
    }

    public function store(StoreBannerRequest $request)
    {
        return $this->banner->store($request);
    }

    public function show(Banner $banner)
    {
        return $this->banner->show($banner);
    }

    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        return $this->banner->update($request, $banner);
    }

    public function updateStatus(Request $request)
    {
        return $this->banner->updateStatus($request);
    }

    public function destroy(Banner $banner)
    {
        return $this->banner->destroy($banner);
    }

    public function trash()
    {
        return $this->banner->trash();
    }

    public function trashData()
    {
        return $this->banner->trashData();
    }

    public function restore($id)
    {
        return $this->banner->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->banner->forceDelete($id);
    } 
}
