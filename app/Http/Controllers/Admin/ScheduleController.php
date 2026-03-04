<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private const DAY_LABELS = ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz'];

    public function index(Request $request)
    {
        $day = (int) $request->get('day', 0);
        $day = max(0, min(6, $day));

        $schedules = Schedule::forDay($day)->ordered()->get();

        return view('admin.schedule.index', [
            'schedules' => $schedules,
            'currentDay' => $day,
            'dayLabels' => self::DAY_LABELS,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'day_of_week' => 'required|integer|min:0|max:6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'title' => 'required|string|max:255',
            'host' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = Schedule::forDay($validated['day_of_week'])->max('sort_order') + 1;

        Schedule::create($validated);

        return redirect()->route('admin.schedule.index', ['day' => $validated['day_of_week']])
            ->with('success', 'Program eklendi.');
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'day_of_week' => 'required|integer|min:0|max:6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'title' => 'required|string|max:255',
            'host' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $schedule->update($validated);

        return redirect()->route('admin.schedule.index', ['day' => $validated['day_of_week']])
            ->with('success', 'Program güncellendi.');
    }

    public function destroy(Schedule $schedule)
    {
        $day = $schedule->day_of_week;
        $schedule->delete();

        return redirect()->route('admin.schedule.index', ['day' => $day])
            ->with('success', 'Program silindi.');
    }

    public function toggle(Schedule $schedule)
    {
        $schedule->update(['is_active' => !$schedule->is_active]);

        return redirect()->route('admin.schedule.index', ['day' => $schedule->day_of_week])
            ->with('success', $schedule->is_active ? 'Program aktif edildi.' : 'Program pasif edildi.');
    }

    public function copy(Request $request, int $fromDay)
    {
        $toDay = (int) $request->input('to_day');
        if ($toDay < 0 || $toDay > 6 || $toDay === $fromDay) {
            return back()->with('error', 'Geçersiz hedef gün.');
        }

        $schedules = Schedule::forDay($fromDay)->ordered()->get();
        $maxOrder = Schedule::forDay($toDay)->max('sort_order') ?? 0;

        foreach ($schedules as $s) {
            Schedule::create([
                'day_of_week' => $toDay,
                'start_time' => $s->start_time,
                'end_time' => $s->end_time,
                'title' => $s->title,
                'host' => $s->host,
                'is_active' => $s->is_active,
                'sort_order' => ++$maxOrder,
            ]);
        }

        return redirect()->route('admin.schedule.index', ['day' => $toDay])
            ->with('success', 'Gün kopyalandı.');
    }
}
