<?php

namespace App\Http\Controllers\Backend;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Repository\Admin\ActivityLogRepositoryInterface;

class ActivityLogController extends Controller
{


    protected $activityLogRepositoryInterface;

    public function __construct(ActivityLogRepositoryInterface $activityLogRepositoryInterface)
    {
        $this->activityLogRepositoryInterface = $activityLogRepositoryInterface;
    }

    public function index()
    {
        return $this->activityLogRepositoryInterface->index();
    }

    public function data(Request $request)
    {
        return $this->activityLogRepositoryInterface->data($request);
    }

   
}
