<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MemberSubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $query = MemberSubmission::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $submissions = $query->paginate(20)->withQueryString();

        return view('admin.member-submissions.index', compact('submissions'));
    }

    public function show(MemberSubmission $submission): View
    {
        $submission->load('user');
        return view('admin.member-submissions.show', compact('submission'));
    }

    public function approve(MemberSubmission $submission): RedirectResponse
    {
        $submission->update(['status' => 'approved']);
        return back()->with('success', 'Gönderi onaylandı.');
    }

    public function reject(MemberSubmission $submission): RedirectResponse
    {
        $submission->update(['status' => 'rejected']);
        return back()->with('success', 'Gönderi reddedildi.');
    }

    public function download(MemberSubmission $submission)
    {
        if ($submission->type !== 'mp3' || !$submission->file_path) {
            return back()->with('error', 'Dosya bulunamadı.');
        }

        $path = Storage::disk('public')->path($submission->file_path);
        if (!file_exists($path)) {
            return back()->with('error', 'Dosya bulunamadı.');
        }

        return response()->download($path, $submission->file_name ?? 'dosya.mp3');
    }

    public function destroy(MemberSubmission $submission): RedirectResponse
    {
        if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
            Storage::disk('public')->delete($submission->file_path);
        }
        $submission->delete();
        return back()->with('success', 'Gönderi silindi.');
    }
}
