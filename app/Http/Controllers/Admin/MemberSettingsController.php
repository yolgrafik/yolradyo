<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberSettingsController extends Controller
{
    public function __construct(
        protected SettingsService $settings
    ) {}

    public function index(): View
    {
        return view('admin.member-settings.index', [
            'approvalRequired' => (bool) $this->settings->get('member_approval_required', true),
            'dailyLimit' => (int) $this->settings->get('member_daily_submission_limit', 5),
            'maxMp3Mb' => (int) $this->settings->get('member_max_mp3_size_mb', 20),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'member_approval_required' => 'nullable|boolean',
            'member_daily_submission_limit' => 'required|integer|min:1|max:100',
            'member_max_mp3_size_mb' => 'required|integer|min:1|max:100',
        ]);

        $this->settings->set('member_approval_required', (bool) ($request->boolean('member_approval_required')), 'boolean');
        $this->settings->set('member_daily_submission_limit', (int) $validated['member_daily_submission_limit'], 'integer');
        $this->settings->set('member_max_mp3_size_mb', (int) $validated['member_max_mp3_size_mb'], 'integer');

        return back()->with('success', 'Üye ayarları kaydedildi.');
    }
}
