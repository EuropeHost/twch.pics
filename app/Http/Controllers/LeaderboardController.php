<?php

namespace App\Http\Controllers;

use App\Models\Clip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        $topClips = Clip::orderByDesc('views')->take(10)->get();
        return view('leaderboards.index', compact('topClips'));
    }

    public function topClips()
    {
        $clips = Clip::select('clips.*',
                DB::raw('SUM(CASE WHEN votes.is_upvote = 1 THEN 1 ELSE -1 END) as net_votes')
            )
            ->leftJoin('votes', 'clips.id', '=', 'votes.clip_id')
            ->groupBy('clips.id')
            ->orderByDesc('net_votes')
            ->with('user')
            ->paginate(20);

        return view('leaderboards.clips', compact('clips'));
    }

    public function topBroadcasters()
    {
        $broadcasters = Clip::select(
                'broadcaster_twitch_id',
                'broadcaster_name',
                'broadcaster_profile_image_url',
                DB::raw('COUNT(DISTINCT clips.id) as total_clips'),
                DB::raw('SUM(clips.views) as total_views')
            )
            ->groupBy('broadcaster_twitch_id', 'broadcaster_name', 'broadcaster_profile_image_url')
            ->orderByDesc('total_views')
            ->paginate(20);

        return view('leaderboards.broadcasters', compact('broadcasters'));
    }

    public function topClippers()
    {
        $clippers = Clip::select(
                'clipper_twitch_id',
                'clipper_name',
                'clipper_profile_image_url',
                DB::raw('COUNT(DISTINCT clips.id) as total_clips'),
                DB::raw('SUM(clips.views) as total_views')
            )
            ->groupBy('clipper_twitch_id', 'clipper_name', 'clipper_profile_image_url')
            ->orderByDesc('total_views')
            ->paginate(20);

        return view('leaderboards.clippers', compact('clippers'));
    }

    public function topSubmitters()
    {
        $submitters = User::select(
                'users.id',
                'users.name',
                'users.avatar',
                'users.twitch_id',
                DB::raw('COUNT(clips.id) as total_submitted_clips')
            )
            ->leftJoin('clips', 'users.id', '=', 'clips.user_id')
            ->groupBy('users.id', 'users.name', 'users.avatar', 'users.twitch_id')
            ->orderByDesc('total_submitted_clips')
            ->paginate(20);

        return view('leaderboards.submitters', compact('submitters'));
    }
}