<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $schedules = DB::table('schedules')->whereNotNull('host')->where('host', '!=', '')->whereNull('dj_id')->get();

        foreach ($schedules as $schedule) {
            $dj = DB::table('dj_profiles')
                ->whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($schedule->host))])
                ->first();

            if ($dj) {
                DB::table('schedules')->where('id', $schedule->id)->update(['dj_id' => $dj->id]);
            }
        }
    }

    public function down(): void
    {
        // Backfill is one-way; no rollback needed
    }
};
