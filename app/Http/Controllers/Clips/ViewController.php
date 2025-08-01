<?php

namespace App\Http\Controllers\Clips;

use App\Http\Controllers\Controller;
use App\Models\Clip;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index(Request $request)
    {
        $clips = Clip::with('user')->latest()->paginate(20);
        return view('clips.index', compact('clips'));
    }

    public function show(string $id)
    {
        $clip = Clip::with(['user','votes','comments' => function ($query) {
            $query->whereNull('parent_id')->with('user', 'replies.user');
        }])->findOrFail($id);
    
        return view('clips.show', compact('clip'));
    }

    public function showByBroadcaster(string $broadcasterTwitchId)
    {
        $clips = Clip::where('broadcaster_twitch_id', $broadcasterTwitchId)
                      ->orderByDesc('views')
                      ->paginate(20);
        return view('clips.broadcaster_clips', compact('clips'));
    }

    public function showByGame(string $gameId)
    {
        $clips = Clip::where('game_id', $gameId)
                      ->orderByDesc('views')
                      ->paginate(20);
        return view('clips.game_clips', compact('clips'));
    }
}