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
        $approvalStatus = $request->get('approval_status');
        $query = ForumPost::with('user')->latest();

        $types = [ForumPost::TYPE_VIDEO, ForumPost::TYPE_MP3, ForumPost::TYPE_PHOTO, ForumPost::TYPE_REQUEST, ForumPost::TYPE_COMPLAINT];
        if (in_array($type, $types)) {
            $query->where('type', $type);
        }
        if (in_array($approvalStatus, ['pending', 'approved', 'rejected'])) {
            $query->where('approval_status', $approvalStatus);
        }

        $posts = $query->paginate(20)->withQueryString();

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

    public function approve(ForumPost $post): RedirectResponse
    {
        $post->update(['approval_status' => ForumPost::APPROVAL_APPROVED]);
        return back()->with('success', 'Gönderi onaylandı.');
    }

    public function reject(ForumPost $post): RedirectResponse
    {
        $post->update(['approval_status' => ForumPost::APPROVAL_REJECTED]);
        return back()->with('success', 'Gönderi reddedildi.');
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
