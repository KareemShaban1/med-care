<?php

namespace App\Repository\Admin;

use App\Models\ActivityLog;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogRepository implements ActivityLogRepositoryInterface
{
    public function index()
    {
        return [];
    }

    public function data($request)
    {
        $query = ActivityLog::with('user');

        $query = $this->applyFilters($query, $request);

        return DataTables::of($query)
            ->editColumn('created_at', fn($item) => $item->created_at->format('Y-m-d H:i:s'))
            ->editColumn('action', fn($item) => $this->translateAction($item->action))
            ->editColumn('model', fn($item) => $this->translateModel($item->model))
            ->editColumn('changes', fn($item) => $this->formatChanges($item))
            ->rawColumns(['changes'])
            ->make(true);
    }

    /**
     * Apply filters to the query
     */
    private function applyFilters($query, $request)
    {
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('model')) {
            $query->where('model', $request->model);
        }

        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }

        if ($request->filled('date_range')) {
            [$start, $end] = explode(' - ', $request->date_range);
            $query->whereBetween('created_at', ["{$start} 00:00:00", "{$end} 23:59:59"]);
        }

        return $query;
    }

    /**
     * Translate action for display
     */
    private function translateAction(string $action): string
    {
        return match ($action) {
            'created' => __('Created'),
            'updated' => __('Updated'),
            'deleted' => __('Deleted'),
            'restored' => __('Restored'),
            'forceDeleted' => __('Force Deleted'),
            'status_updated' => __('Status Updated'),
            default => __('Unknown'),
        };
    }

    /**
     * Translate model for display
     */
    private function translateModel(string $model): string
    {
        return match ($model) {
            'App\Models\Banner' => __('Banner'),
            'App\Models\Category' => __('Category'),
            'App\Models\Product' => __('Product'),
            'App\Models\Order' => __('Order'),
            'App\Models\Client' => __('Client'),
            default => class_basename($model),
        };
    }

    /**
     * Format changes JSON for display
     */
    private function formatChanges($item): string
    {
        if (!$item->changes) {
            return __('N/A');
        }

        try {
            $changes = json_decode($item->changes, true);
            if (!is_array($changes)) return __('Invalid Data');

            $output = '<ul>';
            foreach ($changes as $key => $value) {
                if ($key === 'updated_at') continue;

                $translatedKey = $this->translateField($key);

                if (is_array($value) && isset($value['from'], $value['to'])) {
                    [$from, $to] = [$value['from'], $value['to']];
                    [$from, $to] = $this->translateFieldValues($item->model, $key, $from, $to);
                    $output .= "<li><strong>{$translatedKey}:</strong> {$from} <--- {$to}</li>";
                } else {
                    $output .= "<li><strong>{$translatedKey}:</strong> {$value}</li>";
                }
            }
            $output .= '</ul>';

            return $output;
        } catch (\Throwable $e) {
            return __('Invalid JSON');
        }
    }

    /**
     * Translate field names
     */
    private function translateField(string $field): string
    {
        return match ($field) {
            'address' => __('Address'),
            'name' => __('Name'),
            'email' => __('Email'),
            'date' => __('Date'),
            'title' => __('Title'),
            'status' => __('Status'),
            'stock' => __('Stock'),
            default => ucfirst(str_replace('_', ' ', $field)),
        };
    }

    /**
     * Translate specific field values (like status)
     */
    private function translateFieldValues(string $model, string $field, $from, $to): array
    {
        if ($model === 'App\Models\Product' && $field === 'status') {
            $statuses = [
                'pending' => __('Pending'),
                'processing' => __('Processing'),
                'completed' => __('Completed'),
                'cancelled' => __('Cancelled'),
            ];
            $from = $statuses[$from] ?? $from;
            $to = $statuses[$to] ?? $to;
        }

        return [$from, $to];
    }
}
