<?php

namespace App\Http\Controllers;

use App\Models\Clip;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private function getUserProfileData(string $userTwitchId)
    {
        $appUser = User::where('twitch_id', $userTwitchId)->first();

        $profileUser = [
            'twitch_id' => $userTwitchId,
            'name' => null,
            'profile_image_url' => null,
        ];

        $sampleClipAsBroadcaster = Clip::where('broadcaster_twitch_id', $userTwitchId)->first();
        if ($sampleClipAsBroadcaster) {
            $profileUser['name'] = $sampleClipAsBroadcaster->broadcaster_name;
            $profileUser['profile_image_url'] = $sampleClipAsBroadcaster->broadcaster_profile_image_url;
        } else {
            $sampleClipAsClipper = Clip::where('clipper_twitch_id', $userTwitchId)->first();
            if ($sampleClipAsClipper) {
                $profileUser['name'] = $sampleClipAsClipper->clipper_name;
                $profileUser['profile_image_url'] = $sampleClipAsClipper->clipper_profile_image_url;
            }
        }

        return [
            'appUser' => $appUser,
            'profileUser' => (object) $profileUser,
        ];
    }

    public function showAllClips(string $userTwitchId)
    {
        $data = $this->getUserProfileData($userTwitchId);
        $appUser = $data['appUser'];
        $profileUser = $data['profileUser'];

        $clips = Clip::where(function ($query) use ($userTwitchId, $appUser) {
                $query->where('broadcaster_twitch_id', $userTwitchId)
                      ->orWhere('clipper_twitch_id', $userTwitchId);
                if ($appUser) {
                    $query->orWhere('user_id', $appUser->id);
                }
            })
            ->latest()
            ->paginate(20);

        return view('users.profile', compact('clips', 'profileUser', 'appUser'));
    }

    public function showBroadcastedClips(string $userTwitchId)
    {
        $data = $this->getUserProfileData($userTwitchId);
        $appUser = $data['appUser'];
        $profileUser = $data['profileUser'];

        $clips = Clip::where('broadcaster_twitch_id', $userTwitchId)
            ->orderByDesc('views')
            ->paginate(20);

        return view('users.clips.broadcasted', compact('clips', 'profileUser', 'appUser'));
    }

    public function showClippedClips(string $userTwitchId)
    {
        $data = $this->getUserProfileData($userTwitchId);
        $appUser = $data['appUser'];
        $profileUser = $data['profileUser'];

        $clips = Clip::where('clipper_twitch_id', $userTwitchId)
            ->orderByDesc('views')
            ->paginate(20);

        return view('users.clips.clipped', compact('clips', 'profileUser', 'appUser'));
    }

    public function showSubmittedClips(string $userTwitchId)
    {
        $data = $this->getUserProfileData($userTwitchId);
        $appUser = $data['appUser'];
        $profileUser = $data['profileUser'];

        if (!$appUser) {
            return redirect()->back()->withErrors(['message' => 'This user has not submitted any clips on twch.pics.']);
        }

        $clips = $appUser->clips()->latest()->paginate(20);

        return view('users.clips.submitted', compact('clips', 'profileUser', 'appUser'));
    }
}