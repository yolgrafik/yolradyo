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

        $schedules = Schedule::forDay($day)->active()->with('dj')->ordered()->get();
        $schedulesArray = $schedules->values()->all();

        $nowTime = now()->format('H:i:s');
        $todayDay = now()->dayOfWeekIso - 1; // 1=Mon->0, 7=Sun->6

        $activeIdx = null;
        if ($day === $todayDay && count($schedulesArray) > 0) {
            foreach ($schedulesArray as $idx => $s) {
                $startRaw = is_string($s->start_time) ? $s->start_time : $s->start_time->format('H:i:s');
                $startCompare = substr(preg_replace('/\.\d+$/', '', $startRaw), 0, 8);

                $endRaw = $s->end_time ? (is_string($s->end_time) ? $s->end_time : $s->end_time->format('H:i:s')) : null;
                $next = $schedulesArray[$idx + 1] ?? null;
                $nextStart = $next ? (is_string($next->start_time) ? $next->start_time : $next->start_time->format('H:i:s')) : null;
                $endCompare = $endRaw
                    ? substr(preg_replace('/\.\d+$/', '', $endRaw), 0, 8)
                    : ($nextStart ? substr(preg_replace('/\.\d+$/', '', $nextStart), 0, 8) : '23:59:59');

                if ($nowTime >= $startCompare && $nowTime < $endCompare) {
                    $activeIdx = $idx;
                    break;
                }
            }
        }

        $activeDj = null;
        if ($activeIdx !== null) {
            $activeItem = $schedulesArray[$activeIdx];
            $dj = $activeItem->dj_id ? $activeItem->dj : null;
            if ($dj) {
                $activeDj = [
                    'id' => $dj->id,
                    'name' => $dj->name,
                    'avatar_url' => $dj->avatar_url,
                    'initials' => $dj->display_initials,
                    'tagline' => $dj->bio ?? '',
                    'program_title' => $activeItem->title,
                ];
            }
        }

        $items = collect($schedulesArray)->map(function ($s, $idx) use ($activeIdx) {
            $startRaw = is_string($s->start_time) ? $s->start_time : $s->start_time->format('H:i:s');
            $start = substr($startRaw, 0, 5);
            $endRaw = $s->end_time ? (is_string($s->end_time) ? $s->end_time : $s->end_time->format('H:i:s')) : null;
            $end = $endRaw ? substr($endRaw, 0, 5) : null;

            $isLive = ($idx === $activeIdx);

            $dj = $s->dj_id ? $s->dj : null;
            $djData = $dj ? [
                'id' => $dj->id,
                'name' => $dj->name,
                'avatar_url' => $dj->avatar_url,
                'initials' => $dj->display_initials,
                'tagline' => $dj->bio ?? '',
            ] : null;

            return [
                'start_time' => $start,
                'end_time' => $end,
                'title' => $s->title,
                'description' => $s->description ?? '',
                'host' => $dj ? $dj->name : '',
                'dj' => $djData,
                'is_live' => $isLive,
            ];
        });

        return response()->json([
            'day' => $day,
            'items' => $items,
            'activeDj' => $activeDj,
        ]);
    }
}
