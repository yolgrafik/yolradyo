<?php

namespace App\Services;

use App\Models\DjProfile;
use App\Models\Schedule;

class LiveDjService
{
    /**
     * Get the currently live DJ for display.
     * Priority: A) DB is_live=1, B) Schedule current program host match, C) null
     */
    public function getLiveDj(): ?DjProfile
    {
        // A) Explicitly marked live in DB
        $live = DjProfile::live()->first();
        if ($live) {
            return $live;
        }

        // B) From schedule: current program's host
        $host = $this->getCurrentScheduleHost();
        if ($host) {
            $dj = DjProfile::whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($host))])->first();
            if ($dj) {
                return $dj;
            }
        }

        return null;
    }

    /**
     * Get host name of currently airing program from schedule.
     */
    protected function getCurrentScheduleHost(): ?string
    {
        $todayDay = now()->dayOfWeekIso - 1; // 1=Mon->0, 7=Sun->6
        $schedulesArray = Schedule::forDay($todayDay)->active()->ordered()->get()->values()->all();
        $nowTime = now()->format('H:i:s');

        foreach ($schedulesArray as $idx => $s) {
            $startRaw = is_string($s->start_time) ? $s->start_time : $s->start_time->format('H:i:s');
            $startCompare = substr(preg_replace('/\.\d+$/', '', $startRaw), 0, 8);

            $endRaw = $s->end_time ? (is_string($s->end_time) ? $s->end_time : $s->end_time->format('H:i:s')) : null;
            $next = $schedulesArray[$idx + 1] ?? null;
            $nextStart = $next ? (is_string($next->start_time) ? $next->start_time : $next->start_time->format('H:i:s')) : null;
            $endCompare = $endRaw
                ? substr(preg_replace('/\.\d+$/', '', $endRaw), 0, 8)
                : ($nextStart ? substr(preg_replace('/\.\d+$/', '', $nextStart), 0, 8) : '23:59:59');

            if ($nowTime >= $startCompare && $nowTime < $endCompare && ! empty($s->host)) {
                return trim($s->host);
            }
        }

        return null;
    }
}
