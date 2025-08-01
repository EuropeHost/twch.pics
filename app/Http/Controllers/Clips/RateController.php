<?php

namespace App\Http\Controllers\Clips;

use App\Http\Controllers\Controller;
use App\Models\Clip;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    public function vote(Request $request, Clip $clip)
    {
        $request->validate([
            'type' => ['required', 'in:upvote,downvote'],
        ]);

        $isUpvote = ($request->input('type') === 'upvote');
        $userId = Auth::id();

        $existingVote = $clip->votes()->where('user_id', $userId)->first();

        if ($existingVote) {
            if ($existingVote->is_upvote === $isUpvote) {
                $existingVote->delete();
                return back()->with('info', 'Your vote has been removed.');
            } else {
                $existingVote->is_upvote = $isUpvote;
                $existingVote->save();
                return back()->with('success', 'Your vote has been updated.');
            }
        } else {
            $clip->votes()->create([
                'user_id' => $userId,
                'is_upvote' => $isUpvote,
            ]);
            return back()->with('success', 'Your vote has been cast.');
        }
    }
}