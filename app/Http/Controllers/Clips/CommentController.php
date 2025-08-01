<?php

namespace App\Http\Controllers\Clips;

use App\Http\Controllers\Controller;
use App\Models\Clip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Clip $clip)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|uuid|exists:comments,id',
        ]);

        $comment = $clip->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'parent_id' => $request->input('parent_id'),
        ]);

        return back()->with('success', 'Your comment has been posted!');
    }

    public function destroy(Clip $clip, string $commentId)
    {
        $comment = $clip->comments()->findOrFail($commentId);

        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}