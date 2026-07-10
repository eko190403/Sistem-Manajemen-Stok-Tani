<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    public static function log($action, $description, $model = null, $model_id = null, $old_values = null, $new_values = null)
    {
        if (!Auth::check()) {
            return;
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'model' => $model,
            'model_id' => $model_id,
            'old_values' => $old_values,
            'new_values' => $new_values,
            'ip_address' => request()->ip(),
            'user_agent' => substr(request()->userAgent(), 0, 255),
        ]);
    }
}
