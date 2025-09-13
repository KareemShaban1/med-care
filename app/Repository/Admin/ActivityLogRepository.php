<?php
namespace App\Repository\Admin;

use App\Models\ActivityLog;
use App\Repository\Admin\ActivityLogRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogRepository implements ActivityLogRepositoryInterface
{
    public function index()
    {
        return view('backend.pages.activity-logs.index');
    }

    public function data($request)
    {
        $query = ActivityLog::class::with('user');

        // Filter by Action
        if ($request->has('action') && !empty($request->action)) {
            $query->where('action', $request->action);
        }

        // Filter by Model
        if ($request->has('model') && !empty($request->model)) {
            $query->where('model', $request->model);
        }

        // Filter by User
        if ($request->has('user') && !empty($request->user)) {
            $query->where('user_id', $request->user);
        }

        // Filter by Date Range
        if ($request->has('date_range') && !empty($request->date_range)) {
            [$startDate, $endDate] = explode(' - ', $request->date_range);
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        return DataTables::of($query)
            ->filterColumn('model_id', function ($query, $value) {
                $query->where('model_id', $value);
            })
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('action', function ($item) {
                return match ($item->action) {
                    'created' => __('created'),
                    'updated' => __('updated'),
                    'deleted' => __('deleted'),
                    default => __('Unknown'),
                };
            })
            ->editColumn('model', function ($item) {
                return match ($item->model) {
                    'App\Models\Banner' => __('Banner'),
                    'App\Models\Category' => __('Category'),
                    'App\Models\Product' => __('Product'),
                    'App\Models\Order' => __('Order'),

                    default => $item->model, // Fallback for unexpected values
                };
            })
            ->editColumn('changes', function ($item) {
                if (!$item->changes) {
                    return __('N/A');
                }
            
                try {
                    $parsedChanges = json_decode($item->changes, true);
                    if (!is_array($parsedChanges)) {
                        return __('Invalid Data');
                    }
            
                    $changesList = '<ul>';
                    foreach ($parsedChanges as $key => $value) {
                        if ($key === 'updated_at') {
                            continue; // Skip 'updated_at'
                        }
            
                        $translatedKey = match ($key) {
                            'address' => __('Address'),
                            'name'    => __('Name'),
                            'email'   => __('Email'),
                            'date'    => __('Date'),
                            'title'   => __('Title'),
                            'status'  => __('Status'),
                            'stock'   => __('Stock'),
                            default   => ucfirst(str_replace('_', ' ', $key)),
                        };
            
                        // Handle nested "from" and "to"
                        if (is_array($value) && isset($value['from'], $value['to'])) {
                            $from = $value['from'];
                            $to   = $value['to'];
            
                            // Special case for Product status translation
                            if ($item->model === 'App\Models\Product' && $key === 'status') {
                                $from = match ($from) {
                                    'pending'    => __('Pending'),
                                    'processing' => __('Processing'),
                                    'completed'  => __('Completed'),
                                    'cancelled'  => __('Cancelled'),
                                    default      => $from,
                                };
            
                                $to = match ($to) {
                                    'pending'    => __('Pending'),
                                    'processing' => __('Processing'),
                                    'completed'  => __('Completed'),
                                    'cancelled'  => __('Cancelled'),
                                    default      => $to,
                                };
                            }
            
                            $changesList .= "<li><strong>{$translatedKey}:</strong> {$from} <--- {$to}</li>";
                        } else {
                            // Fallback for non-array values
                            $changesList .= "<li><strong>{$translatedKey}:</strong> {$value}</li>";
                        }
                    }
                    $changesList .= '</ul>';
            
                    return $changesList;
                } catch (\Exception $e) {
                    return __('Invalid JSON');
                }
            })
            
            ->rawColumns(['changes'])
            ->make(true);
    }
}
