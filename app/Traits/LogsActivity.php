<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        foreach (static::getRecordEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->logActivity($event);
            });
        }
    }

    protected static function getRecordEvents()
    {
        return ['created', 'updated', 'deleted'];
    }

    public function logActivity($event)
    {
        $oldValues = null;
        $newValues = null;

        if ($event === 'updated') {
            $newValues = array_diff_assoc($this->getAttributes(), $this->getOriginal());
            $oldValues = array_intersect_key($this->getOriginal(), $newValues);
            
            // Filter out timestamps and irrelevant fields
            $exclude = ['updated_at', 'created_at'];
            $newValues = array_diff_key($newValues, array_flip($exclude));
            $oldValues = array_diff_key($oldValues, array_flip($exclude));

            if (empty($newValues)) return;
        } elseif ($event === 'created') {
            $newValues = $this->getAttributes();
        } elseif ($event === 'deleted') {
            $oldValues = $this->getAttributes();
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'event' => $event,
            'auditable_type' => get_class($this),
            'auditable_id' => $this->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'url' => Request::fullUrl(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    public function activities()
    {
        return $this->morphMany(ActivityLog::class, 'auditable');
    }
}
