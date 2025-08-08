<?php

namespace App\Http\Controllers;

use App\Models\ForumDiscussion;
use App\Models\ForumComment;
use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ActivityLogger;

class ForumDiscussionController extends Controller
{
    use ActivityLogger;

    public function index(Request $request)
    {
        $query = ForumDiscussion::with(['user', 'category', 'comments']);

        // Filter by category if provided
        if ($request->has('category') && $request->category !== 'semua') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        $discussions = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = ForumCategory::all();

        return view('forum-diskusi.daftar', compact('discussions', 'categories'));
    }

    public function show($id)
    {
        $discussion = ForumDiscussion::with([
            'user',
            'category',
            'comments.user',
            'likes',
            'comments.likes',
        ])->findOrFail($id);
        return view('forum-diskusi.detail', compact('discussion'));
    }

    public function create()
    {
        $categories = ForumCategory::all();
        return view('forum-diskusi.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'forum_category_id' => 'required|exists:forum_categories,id'
        ]);

        ForumDiscussion::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'forum_category_id' => $request->forum_category_id,
            'likes_count' => 0,
            'comments_count' => 0
        ]);

        $this->logForumDiscussion($request->title);

        return redirect()->route('forum.diskusi')->with('success', 'Diskusi berhasil dibuat!');
    }

    public function storeComment(Request $request, $discussionId)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $comment = ForumComment::create([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'forum_discussion_id' => $discussionId,
            'likes_count' => 0
        ]);

        // Update comments count
        $discussion = ForumDiscussion::find($discussionId);
        $discussion->increment('comments_count');

        $this->logForumComment($discussion->title);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $discussion = ForumDiscussion::findOrFail($id);
        $categories = ForumCategory::all();
        return view('forum-diskusi.form', compact('discussion', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'forum_category_id' => 'required|exists:forum_categories,id'
        ]);

        $discussion = ForumDiscussion::findOrFail($id);
        $discussion->update([
            'title' => $request->title,
            'content' => $request->content,
            'forum_category_id' => $request->forum_category_id
        ]);

        $this->logForumDiscussionUpdate($request->title);

        return redirect()->route('forum.diskusi')->with('success', 'Diskusi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $discussion = ForumDiscussion::findOrFail($id);
        $discussionTitle = $discussion->title;
        $discussion->delete();

        $this->logForumDiscussionDelete($discussionTitle);

        return redirect()->route('forum.diskusi')->with('success', 'Diskusi berhasil dihapus!');
    }

    /**
     * Toggle like on a discussion by the authenticated user.
     */
    public function toggleLikeDiscussion($id)
    {
        $discussion = ForumDiscussion::findOrFail($id);
        $likeQuery = $discussion->likes()->where('user_id', Auth::id());
        $existing = $likeQuery->first();

        if ($existing) {
            $likeQuery->delete();
            if ($discussion->likes_count > 0) {
                $discussion->decrement('likes_count');
            }
            return back()->with('success', 'Batal suka diskusi.');
        }

        $discussion->likes()->create(['user_id' => Auth::id()]);
        $discussion->increment('likes_count');
        return back()->with('success', 'Menyukai diskusi.');
    }

    /**
     * Toggle like on a comment by the authenticated user.
     */
    public function toggleLikeComment($commentId)
    {
        $comment = ForumComment::findOrFail($commentId);
        $likeQuery = $comment->likes()->where('user_id', Auth::id());
        $existing = $likeQuery->first();

        if ($existing) {
            $likeQuery->delete();
            if ($comment->likes_count > 0) {
                $comment->decrement('likes_count');
            }
            return back()->with('success', 'Batal suka komentar.');
        }

        $comment->likes()->create(['user_id' => Auth::id()]);
        $comment->increment('likes_count');
        return back()->with('success', 'Menyukai komentar.');
    }
}
