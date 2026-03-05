<?php

namespace App\Http\Controllers;

use App\Models\MemberSubmission;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MemberSubmissionFrontendController extends Controller
{
    public function show(SettingsService $settings): View|RedirectResponse
    {
        $user = auth()->user();
        if (!$user->isApproved()) {
            return redirect()->route('profile')
                ->with('error', 'Gönderi yapabilmek için hesabınızın onaylanması gerekiyor.');
        }

        $maxMb = (int) $settings->get('member_max_mp3_size_mb', 20);
        $dailyLimit = (int) $settings->get('member_daily_submission_limit', 5);

        $todayCount = MemberSubmission::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->count();

        return view('frontend.bize-gonder', [
            'maxMp3Mb' => $maxMb,
            'dailyLimit' => $dailyLimit,
            'todayCount' => $todayCount,
        ]);
    }

    public function store(Request $request, SettingsService $settings): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->isApproved()) {
            return back()->with('error', 'Gönderi yapabilmek için hesabınızın onaylanması gerekiyor.');
        }

        $maxMb = (int) $settings->get('member_max_mp3_size_mb', 20);
        $dailyLimit = (int) $settings->get('member_daily_submission_limit', 5);

        $todayCount = MemberSubmission::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->count();

        if ($todayCount >= $dailyLimit) {
            return back()->with('error', "Günlük gönderi limitinize ({$dailyLimit}) ulaştınız. Yarın tekrar deneyin.");
        }

        $validated = $request->validate([
            'type' => 'required|in:istek,sikayet,video,mp3',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'video_url' => 'required_if:type,video|nullable|url|max:500',
            'mp3_file' => 'required_if:type,mp3|nullable|file|mimes:mp3,mpeg|max:' . ($maxMb * 1024),
        ], [
            'type.required' => 'Lütfen gönderi türünü seçin.',
            'title.required' => 'Başlık zorunludur.',
            'video_url.required_if' => 'Video linki zorunludur.',
            'video_url.url' => 'Geçerli bir video URL girin.',
            'mp3_file.required_if' => 'MP3 dosyası zorunludur.',
            'mp3_file.mimes' => 'Sadece MP3 dosyası yükleyebilirsiniz.',
            'mp3_file.max' => "MP3 dosyası en fazla {$maxMb}MB olabilir.",
        ]);

        $filePath = null;
        $fileName = null;

        if ($request->hasFile('mp3_file')) {
            $file = $request->file('mp3_file');
            $path = $file->store('uploads/mp3', 'public');
            $filePath = $path;
            $fileName = $file->getClientOriginalName();
        }

        MemberSubmission::create([
            'user_id' => $user->id,
            'type' => $validated['type'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Gönderiniz alındı. İncelendikten sonra size dönüş yapılacaktır.');
    }
}
