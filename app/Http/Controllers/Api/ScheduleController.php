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

        $nowTime = now()->format('H:i:s');
        $todayDay = now()->dayOfWeekIso - 1; // 1=Mon -> 0, 7=Sun -> 6
        $items = collect($schedulesArray)->map(function ($s, $idx) use ($nowTime, $day, $todayDay, $schedulesArray) {
            $startRaw = is_string($s->start_time) ? $s->start_time : $s->start_time->format('H:i:s');
            $start = substr($startRaw, 0, 5);
            $endRaw = $s->end_time ? (is_string($s->end_time) ? $s->end_time : $s->end_time->format('H:i:s')) : null;
            $end = $endRaw ? substr($endRaw, 0, 5) : null;

            $startCompare = substr(preg_replace('/\.\d+$/', '', $startRaw), 0, 8);
            $nextStart = isset($schedulesArray[$idx + 1])
                ? (is_string($schedulesArray[$idx + 1]->start_time) ? $schedulesArray[$idx + 1]->start_time : $schedulesArray[$idx + 1]->start_time->format('H:i:s'))
                : null;
            $endCompare = $endRaw ? substr(preg_replace('/\.\d+$/', '', $endRaw), 0, 8) : ($nextStart ? substr(preg_replace('/\.\d+$/', '', $nextStart), 0, 8) : '23:59:59');

            $isLive = ($day === $todayDay) && ($nowTime >= $startCompare && $nowTime < $endCompare);

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
