<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DjProfile;
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

        $liveDj = DjProfile::where('is_live', true)->first();

        if ($liveDj) {
            // Öncelik 1: Canlı DJ varsa dj_id eşleşmesine göre is_live
            // Birden fazla eşleşmede: saat aralığına göre şu anki olanı seç, yoksa ilkini
            $liveDjId = (int) $liveDj->id;
            $matchingIndices = [];
            foreach ($schedulesArray as $idx => $s) {
                if ($s->dj_id === $liveDjId) {
                    $matchingIndices[] = $idx;
                }
            }

            $liveIdx = null;
            if (count($matchingIndices) === 1) {
                $liveIdx = $matchingIndices[0];
            } elseif (count($matchingIndices) > 1) {
                $nowTime = now()->format('H:i:s');
                $todayDay = now()->dayOfWeekIso - 1;
                foreach ($matchingIndices as $idx) {
                    $s = $schedulesArray[$idx];
                    $startRaw = is_string($s->start_time) ? $s->start_time : $s->start_time->format('H:i:s');
                    $startCompare = substr(preg_replace('/\.\d+$/', '', $startRaw), 0, 8);
                    $endRaw = $s->end_time ? (is_string($s->end_time) ? $s->end_time : $s->end_time->format('H:i:s')) : null;
                    $next = $schedulesArray[$idx + 1] ?? null;
                    $nextStart = $next ? (is_string($next->start_time) ? $next->start_time : $next->start_time->format('H:i:s')) : null;
                    $endCompare = $endRaw ? substr(preg_replace('/\.\d+$/', '', $endRaw), 0, 8) : ($nextStart ? substr(preg_replace('/\.\d+$/', '', $nextStart), 0, 8) : '23:59:59');
                    if ($day === $todayDay && $nowTime >= $startCompare && $nowTime < $endCompare) {
                        $liveIdx = $idx;
                        break;
                    }
                }
                $liveIdx = $liveIdx ?? $matchingIndices[0];
            }

            $items = collect($schedulesArray)->map(function ($s, $idx) use ($liveDjId, $liveIdx) {
                $startRaw = is_string($s->start_time) ? $s->start_time : $s->start_time->format('H:i:s');
                $start = substr($startRaw, 0, 5);
                $endRaw = $s->end_time ? (is_string($s->end_time) ? $s->end_time : $s->end_time->format('H:i:s')) : null;
                $end = $endRaw ? substr($endRaw, 0, 5) : null;

                $isLive = ($s->dj_id === $liveDjId && $liveIdx !== null && $idx === $liveIdx);

                $dj = $s->dj;
                $djData = $dj ? [
                    'id' => $dj->id,
                    'name' => $dj->name,
                    'avatar_url' => $dj->avatar_url,
                    'initials' => $dj->display_initials,
                ] : null;

                return [
                    'start_time' => $start,
                    'end_time' => $end,
                    'title' => $s->title,
                    'host' => $dj?->name ?? $s->host ?? '',
                    'dj' => $djData,
                    'is_live' => $isLive,
                ];
            });
        } else {
            // Öncelik 2: Canlı DJ yoksa saat aralığına göre is_live (fallback)
            $nowTime = now()->format('H:i:s');
            $todayDay = now()->dayOfWeekIso - 1;
            $items = collect($schedulesArray)->map(function ($s, $idx) use ($nowTime, $day, $todayDay, $schedulesArray) {
                $startRaw = is_string($s->start_time) ? $s->start_time : $s->start_time->format('H:i:s');
                $start = substr($startRaw, 0, 5);
                $endRaw = $s->end_time ? (is_string($s->end_time) ? $s->end_time : $s->end_time->format('H:i:s')) : null;
                $end = $endRaw ? substr($endRaw, 0, 5) : null;

                $startCompare = substr(preg_replace('/\.\d+$/', '', $startRaw), 0, 8);
                $next = $schedulesArray[$idx + 1] ?? null;
                $nextStart = $next ? (is_string($next->start_time) ? $next->start_time : $next->start_time->format('H:i:s')) : null;
                $endCompare = $endRaw ? substr(preg_replace('/\.\d+$/', '', $endRaw), 0, 8) : ($nextStart ? substr(preg_replace('/\.\d+$/', '', $nextStart), 0, 8) : '23:59:59');

                $isLive = ($day === $todayDay) && ($nowTime >= $startCompare && $nowTime < $endCompare);

                $dj = $s->dj;
                $djData = $dj ? [
                    'id' => $dj->id,
                    'name' => $dj->name,
                    'avatar_url' => $dj->avatar_url,
                    'initials' => $dj->display_initials,
                ] : null;

                return [
                    'start_time' => $start,
                    'end_time' => $end,
                    'title' => $s->title,
                    'host' => $dj?->name ?? $s->host ?? '',
                    'dj' => $djData,
                    'is_live' => $isLive,
                ];
            });
        }

        return response()->json([
            'day' => $day,
            'items' => $items,
        ]);
    }
}
