<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DjProfile;
use App\Models\Programci;
use App\Models\Schedule;
use App\Models\SchedulePreset;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private const DAY_LABELS = ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'];

    public function index(Request $request)
    {
        $day = (int) $request->get('day', 0);
        $day = max(0, min(6, $day));

        $schedules = Schedule::forDay($day)->with(['dj', 'programci'])->ordered()->get();
        $djProfiles = DjProfile::orderBy('name')->get();
        $programcilar = Programci::orderBy('sira')->orderBy('ad')->get();
        $presets = SchedulePreset::orderBy('sort_order')->get();

        return view('admin.schedule.index', [
            'schedules' => $schedules,
            'djProfiles' => $djProfiles,
            'programcilar' => $programcilar,
            'presets' => $presets,
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
            'description' => 'nullable|string|max:1000',
            'host' => 'nullable|string|max:255',
            'dj_id' => 'nullable|integer|exists:dj_profiles,id',
            'programci_id' => 'nullable|integer|exists:programcilar,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = Schedule::forDay($validated['day_of_week'])->max('sort_order') + 1;
        $validated['dj_id'] = $request->input('dj_id') ?: null;
        $validated['programci_id'] = $request->input('programci_id') ?: null;

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
            'description' => 'nullable|string|max:1000',
            'host' => 'nullable|string|max:255',
            'dj_id' => 'nullable|integer|exists:dj_profiles,id',
            'programci_id' => 'nullable|integer|exists:programcilar,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['dj_id'] = $request->input('dj_id') ?: null;
        $validated['programci_id'] = $request->input('programci_id') ?: null;

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
                'description' => $s->description,
                'host' => $s->host,
                'dj_id' => $s->dj_id,
                'programci_id' => $s->programci_id,
                'is_active' => $s->is_active,
                'sort_order' => ++$maxOrder,
            ]);
        }

        return redirect()->route('admin.schedule.index', ['day' => $toDay])
            ->with('success', 'Gün kopyalandı.');
    }

    public function storePreset(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ]);

        $validated['sort_order'] = SchedulePreset::max('sort_order') + 1;
        SchedulePreset::create($validated);

        return redirect()->route('admin.schedule.index', ['day' => $request->get('day', 0)])
            ->with('success', 'Hızlı ekle programı eklendi.');
    }

    public function updatePreset(Request $request, SchedulePreset $preset)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ]);

        $preset->update($validated);

        return redirect()->route('admin.schedule.index', ['day' => $request->get('day', 0)])
            ->with('success', 'Hızlı ekle programı güncellendi.');
    }

    public function destroyPreset(Request $request, SchedulePreset $preset)
    {
        $preset->delete();

        return redirect()->route('admin.schedule.index', ['day' => $request->get('day', 0)])
            ->with('success', 'Hızlı ekle programı silindi.');
    }
}
