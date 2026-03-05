<?php

namespace App\Http\Controllers;

use App\Models\ForumComment;
use App\Models\ForumPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->get('type');
        $query = ForumPost::with('user')->latest();

        if (in_array($type, [ForumPost::TYPE_REQUEST, ForumPost::TYPE_COMPLAINT])) {
            $query->where('type', $type);
        }

        $posts = $query->paginate(15);

        return view('frontend.forum.index', [
            'posts' => $posts,
            'currentType' => $type,
        ]);
    }

    public function create(): View
    {
        return view('frontend.forum.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (!$user->isApproved()) {
            return back()->with('error', 'Forum gönderisi yapabilmek için hesabınızın onaylanması gerekiyor.');
        }

        $todayCount = ForumPost::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->count();

        if ($todayCount >= 5) {
            return back()->with('error', 'Günlük gönderi limitinize (5) ulaştınız. Yarın tekrar deneyin.');
        }

        $validated = $request->validate([
            'type' => 'required|in:request,complaint',
            'title' => 'required|string|max:120',
            'body' => 'required|string|min:20|max:2000',
        ], [
            'type.required' => 'Lütfen tür seçin.',
            'title.required' => 'Başlık zorunludur.',
            'title.max' => 'Başlık en fazla 120 karakter olabilir.',
            'body.required' => 'Mesaj zorunludur.',
            'body.min' => 'Mesaj en az 20 karakter olmalıdır.',
            'body.max' => 'Mesaj en fazla 2000 karakter olabilir.',
        ]);

        $post = ForumPost::create([
            'user_id' => $user->id,
            'type' => $validated['type'],
            'title' => $validated['title'],
            'slug' => ForumPost::makeSlug($validated['title']),
            'body' => $validated['body'],
            'status' => ForumPost::STATUS_OPEN,
        ]);

        return redirect()->route('forum.show', $post->slug)
            ->with('success', 'Gönderiniz yayınlandı.');
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
