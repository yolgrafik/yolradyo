<?php

namespace App\Helpers;

use App\Models\AdminActivityLog;
use Illuminate\Support\Facades\Schema;

class ActivityLogger
{
    public static function log(string $action, ?array $meta = null, ?int $adminId = null): void
    {
        if (!Schema::hasTable('admin_activity_logs')) {
            return;
        }
        try {
            AdminActivityLog::create([
                'admin_id' => $adminId ?? session('admin_id'),
                'action' => $action,
                'meta' => $meta,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Silently fail during migrations
        }
    }
}
