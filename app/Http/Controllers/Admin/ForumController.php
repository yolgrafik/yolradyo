<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumComment;
use App\Models\ForumPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumController extends Controller
{
    public function posts(Request $request): View
    {
        $type = $request->get('type');
        $query = ForumPost::with('user')->latest();

        if (in_array($type, [ForumPost::TYPE_REQUEST, ForumPost::TYPE_COMPLAINT])) {
            $query->where('type', $type);
        }

        $posts = $query->paginate(20);

        return view('admin.forum.posts', [
            'posts' => $posts,
            'currentType' => $type,
        ]);
    }

    public function toggleStatus(ForumPost $post): RedirectResponse
    {
        $post->update([
            'status' => $post->status === ForumPost::STATUS_OPEN
                ? ForumPost::STATUS_CLOSED
                : ForumPost::STATUS_OPEN,
        ]);

        return back()->with('success', 'Durum güncellendi.');
    }

    public function destroyPost(ForumPost $post): RedirectResponse
    {
        $post->delete();
        return back()->with('success', 'Gönderi silindi.');
    }

    public function comments(): View
    {
        $comments = ForumComment::with(['post', 'user'])->latest()->paginate(30);
        return view('admin.forum.comments', ['comments' => $comments]);
    }

    public function destroyComment(ForumComment $comment): RedirectResponse
    {
        $comment->delete();
        return back()->with('success', 'Yorum silindi.');
    }
}
