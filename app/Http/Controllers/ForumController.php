<?php

namespace App\Http\Controllers;

use App\Models\ForumComment;
use App\Models\ForumPost;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->get('type');
        $query = ForumPost::with('user')->latest();

        $types = [ForumPost::TYPE_VIDEO, ForumPost::TYPE_MP3, ForumPost::TYPE_PHOTO, ForumPost::TYPE_REQUEST, ForumPost::TYPE_COMPLAINT];
        if (in_array($type, $types)) {
            $query->where('type', $type);
        }

        $posts = $query->paginate(15);

        return view('frontend.forum.index', [
            'posts' => $posts,
            'currentType' => $type,
        ]);
    }

    public function create(SettingsService $settings): View
    {
        $maxMp3Mb = (int) $settings->get('member_max_mp3_size_mb', 20);
        $maxPhotoMb = 10;
        $todayCount = ForumPost::where('user_id', auth()->id())->whereDate('created_at', today())->count();

        return view('frontend.forum.create', [
            'maxMp3Mb' => $maxMp3Mb,
            'maxPhotoMb' => $maxPhotoMb,
            'maxVideoMb' => (int) $settings->get('member_max_video_size_mb', 500),
            'todayCount' => $todayCount,
        ]);
    }

    public function store(Request $request, SettingsService $settings): RedirectResponse
    {
        $user = $request->user();
        if (!$user->isApproved()) {
            return back()->with('error', 'Forum gönderisi yapabilmek için hesabınızın onaylanması gerekiyor.');
        }

        $todayCount = ForumPost::where('user_id', $user->id)->whereDate('created_at', today())->count();
        if ($todayCount >= 5) {
            return back()->with('error', 'Günlük gönderi limitinize (5) ulaştınız. Yarın tekrar deneyin.');
        }

        $maxMp3Mb = (int) $settings->get('member_max_mp3_size_mb', 20);
        $maxPhotoMb = 5;
        $maxVideoMb = (int) $settings->get('member_max_video_size_mb', 500);

        $rules = [
            'type' => 'required|in:video,mp3,photo,request,complaint',
            'title' => 'required|string|max:120',
            'body' => 'required_if:type,photo,video|nullable|string|min:5|max:2000',
            'video_url' => 'nullable|url|max:500',
            'video_file' => 'nullable|file|mimes:mp4,mov,webm|max:' . ($maxVideoMb * 1024),
            'mp3_file' => 'required_if:type,mp3|nullable|file|mimes:mp3,mpeg|max:' . ($maxMp3Mb * 1024),
            'photo_file' => 'required_if:type,photo|nullable|file|mimes:jpeg,jpg,png,webp|max:' . ($maxPhotoMb * 1024),
            'disclaimer_accepted' => 'required|accepted',
        ];

        $messages = [
            'type.required' => 'Lütfen tür seçin.',
            'title.required' => 'Başlık zorunludur.',
            'body.required' => 'Açıklama zorunludur.',
            'body.min' => 'Mesaj en az 5 karakter olmalıdır.',
            'video_url.url' => 'Geçerli bir video URL girin.',
            'mp3_file.required_if' => 'MP3 dosyası zorunludur.',
            'mp3_file.mimes' => 'Sadece MP3 dosyası yükleyebilirsiniz.',
            'mp3_file.max' => "MP3 en fazla {$maxMp3Mb}MB olabilir.",
            'video_file.max' => "Video en fazla {$maxVideoMb}MB olabilir.",
            'photo_file.required_if' => 'Fotoğraf dosyası zorunludur.',
            'photo_file.mimes' => 'Sadece JPG, PNG veya WebP yükleyebilirsiniz.',
            'photo_file.max' => "Fotoğraf en fazla {$maxPhotoMb}MB olabilir.",
            'disclaimer_accepted.required' => 'Sorumluluk reddi kabul edilmelidir.',
            'disclaimer_accepted.accepted' => 'Sorumluluk reddini kabul etmelisiniz.',
        ];

        $validated = $request->validate($rules, $messages);

        if (in_array($validated['type'], ['request', 'complaint']) && strlen($validated['body'] ?? '') < 20) {
            return back()->withErrors(['body' => 'İstek ve şikayet için mesaj en az 20 karakter olmalıdır.'])->withInput();
        }

        if (in_array($validated['type'], ['photo', 'video']))
        {
            $body = trim($validated['body'] ?? '');
            if (strlen($body) < 10) {
                return back()->withErrors(['body' => 'Foto ve video için açıklama en az 10 karakter olmalıdır.'])->withInput();
            }
        }

        if ($validated['type'] === 'video') {
            $hasUrl = !empty(trim($validated['video_url'] ?? ''));
            $hasFile = $request->hasFile('video_file');
            if (!$hasUrl && !$hasFile) {
                return back()->withErrors(['video_url' => 'Video linki veya video dosyası zorunludur.'])->withInput();
            }
        }

        $videoUrl = null;
        $filePath = null;
        $fileName = null;
        $fileType = null;

        if ($request->type === 'video' && !empty(trim($validated['video_url'] ?? ''))) {
            $videoUrl = $validated['video_url'];
        }

        if ($request->hasFile('mp3_file')) {
            $file = $request->file('mp3_file');
            $filePath = $file->store('uploads/forum/mp3', 'public');
            $fileName = $file->getClientOriginalName();
            $fileType = 'mp3';
        } elseif ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filePath = $file->store('uploads/listener/photos', 'public');
            $fileName = $file->getClientOriginalName();
            $fileType = 'photo';
        } elseif ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $filePath = $file->store('uploads/listener/videos', 'public');
            $fileName = $file->getClientOriginalName();
            $fileType = 'video';
        }

        $body = $validated['body'] ?? '';

        $post = ForumPost::create([
            'user_id' => $user->id,
            'type' => $validated['type'],
            'title' => $validated['title'],
            'slug' => ForumPost::makeSlug($validated['title']),
            'body' => $body,
            'status' => ForumPost::STATUS_OPEN,
            'approval_status' => in_array($validated['type'], ['photo', 'video']) ? ForumPost::APPROVAL_PENDING : ForumPost::APPROVAL_APPROVED,
            'video_url' => $videoUrl,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
        ]);

        $successMsg = in_array($validated['type'], ['photo', 'video'])
            ? 'Gönderiniz alındı. Onay sonrası yayınlanacaktır.'
            : 'Gönderiniz yayınlandı.';

        return redirect()->route('forum.show', $post->slug)
            ->with('success', $successMsg);
    }

    public function show(string $slug): View|RedirectResponse
    {
        $post = ForumPost::with(['user', 'comments.user'])->where('slug', $slug)->firstOrFail();
        return view('frontend.forum.show', ['post' => $post]);
    }

    public function storeComment(Request $request, string $slug): RedirectResponse
    {
        $user = $request->user();
        if (!$user->isApproved()) {
            return back()->with('error', 'Yorum yapabilmek için hesabınızın onaylanması gerekiyor.');
        }

        $post = ForumPost::where('slug', $slug)->firstOrFail();

        if ($post->status === ForumPost::STATUS_CLOSED) {
            return back()->with('error', 'Bu gönderi yorumlara kapatılmış.');
        }

        $validated = $request->validate([
            'body' => 'required|string|min:5|max:1000',
        ], [
            'body.required' => 'Yorum boş olamaz.',
            'body.min' => 'Yorum en az 5 karakter olmalıdır.',
            'body.max' => 'Yorum en fazla 1000 karakter olabilir.',
        ]);

        ForumComment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Yorumunuz eklendi.');
    }
}
