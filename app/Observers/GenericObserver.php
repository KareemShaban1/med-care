<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GenericObserver
{
    /**
     * Handle the model event
     */
    public function handle(Model $model, string $action, array $additionalData = [])
    {
        $changes = [];
        $original = $model->getOriginal();
        
        if ($action === 'updated') {
            $changes = $this->getChanges($model);
        } elseif ($action === 'status_updated') {
            $changes = [
                'status' => [
                    'from' => $original['status'] ?? null,
                    'to' => $model->status
                ]
            ];
        }

        // Handle custom actions
        if (!empty($additionalData['custom_action'])) {
            $action = $additionalData['custom_action'];
            if (isset($additionalData['changes'])) {
                $changes = array_merge($changes, $additionalData['changes']);
            }
        }

        ActivityLog::create([
            'action' => $action,
            'model' => get_class($model),
            'model_id' => $model->getKey(),
            'changes' => !empty($changes) ? json_encode($changes) : null,
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'additional_data' => !empty($additionalData) ? json_encode($additionalData) : null,
        ]);
    }

    /**
     * Get detailed changes including old and new values
     */
    protected function getChanges(Model $model): array
    {
        $changes = [];
        $original = $model->getOriginal();
        
        foreach ($model->getChanges() as $key => $newValue) {
            // Skip timestamps and remember_token
            if (in_array($key, ['updated_at', 'created_at', 'remember_token'])) {
                continue;
            }
            
            $oldValue = $original[$key] ?? null;
            
            // Handle JSON fields
            if (is_array($oldValue) || is_array($newValue)) {
                $oldValue = is_array($oldValue) ? json_encode($oldValue) : $oldValue;
                $newValue = is_array($newValue) ? json_encode($newValue) : $newValue;
            }
            
            $changes[$key] = [
                'from' => $oldValue,
                'to' => $newValue
            ];
        }
        
        return $changes;
    }

    /**
     * Handle model created event
     */
    public function created(Model $model)
    {
        $this->handle($model, 'created');
    }

    /**
     * Handle model updated event
     */
    public function updated(Model $model)
    {
        // Check if this is a status update
        if ($model->wasChanged('status')) {
            $this->handle($model, 'status_updated');
        } else {
            $this->handle($model, 'updated');
        }
    }

    /**
     * Handle model deleted event
     */
    public function deleted(Model $model)
    {
        $action = $model->isForceDeleting() ? 'force_deleted' : 'deleted';
        $this->handle($model, $action);
    }

    /**
     * Handle model restored event
     */
    public function restored(Model $model)
    {
        $this->handle($model, 'restored');
    }

    /**
     * Handle model force deleted event
     */
    public function forceDeleted(Model $model)
    {
        $this->handle($model, 'force_deleted');
    }

    /**
     * Handle custom model events
     */
    public function __call($method, $parameters)
    {
        if (Str::startsWith($method, 'on')) {
            $action = Str::snake(substr($method, 2));
            $model = $parameters[0] ?? null;
            $data = $parameters[1] ?? [];
            
            if ($model instanceof Model) {
                $this->handle($model, $action, ['custom_action' => $action] + $data);
                return;
            }
        }
        
        // No parent call needed as we don't extend any class
        throw new \BadMethodCallException(sprintf(
            'Method %s::%s does not exist.', static::class, $method
        ));
    }
}
