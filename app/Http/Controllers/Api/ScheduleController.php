<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $day = (int) $request->get('day', 0);
        $day = max(0, min(6, $day));

        $schedules = Schedule::forDay($day)->active()->ordered()->get();
        $schedulesArray = $schedules->values()->all();

        $now = now();
        $todayDay = $now->dayOfWeekIso - 1; // 1=Mon -> 0, 7=Sun -> 6
        $items = collect($schedulesArray)->map(function ($s, $idx) use ($now, $day, $todayDay, $schedulesArray) {
            $start = is_string($s->start_time) ? substr($s->start_time, 0, 5) : $s->start_time->format('H:i');
            $end = $s->end_time ? (is_string($s->end_time) ? substr($s->end_time, 0, 5) : $s->end_time->format('H:i')) : null;
            $startDt = \Carbon\Carbon::parse($s->start_time);
            $endDt = $end ? \Carbon\Carbon::parse($s->end_time) : (
                isset($schedulesArray[$idx + 1]) ? \Carbon\Carbon::parse($schedulesArray[$idx + 1]->start_time) : $startDt->copy()->addHours(3)
            );
            $isLive = ($day === $todayDay) && $now->between($startDt, $endDt);
            return [
                'start_time' => $start,
                'end_time' => $end,
                'title' => $s->title,
                'host' => $s->host ?? '',
                'is_live' => $isLive,
            ];
        });

        return response()->json([
            'day' => $day,
            'items' => $items,
        ]);
    }
}
