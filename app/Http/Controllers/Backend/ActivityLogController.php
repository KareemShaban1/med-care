<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Admin\ActivityLogRepositoryInterface;

class ActivityLogController extends Controller
{


    protected $activityLogRepo;

    public function __construct(ActivityLogRepositoryInterface $activityLogRepo)
    {
        $this->activityLogRepo = $activityLogRepo;
    }

    public function index()
    {
        return view('backend.pages.activity-logs.index');
    }

    public function data(Request $request)
    {
        return $this->activityLogRepo->data($request);
    }

   
}
