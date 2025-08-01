<?php

namespace App\Http\Controllers\Clips;

use App\Http\Controllers\Controller;
use App\Models\Clip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SubmitController extends Controller
{
    public function create()
    {
        return view('clips.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'clip_url' => 'nullable|url',
            'clip_id_direct' => 'nullable|string|max:255',
        ]);

        $twitchClipId = null;

        if (!empty($request->input('clip_id_direct'))) {
            $twitchClipId = $request->input('clip_id_direct');
        } elseif (!empty($request->input('clip_url'))) {
            $twitchClipId = $this->extractClipIdFromUrl($request->input('clip_url'));
        }

        if (empty($twitchClipId)) {
            return back()->withErrors(['clip_url' => 'Please provide a valid Twitch Clip URL or a Direct Twitch Clip ID.']);
        }

        if (Clip::where('twitch_clip_id', $twitchClipId)->exists()) {
            return back()->withErrors(['clip_url' => 'This clip has already been submitted to twch.pics.']);
        }

        $twitchClientId = env('TWITCH_CLIENT_ID');
        $twitchClientSecret = env('TWITCH_CLIENT_SECRET');

        if (!$twitchClientId || !$twitchClientSecret) {
            return back()->withErrors(['api_error' => 'Twitch API client credentials are not set in the .env file.']);
        }

        $accessToken = $this->getTwitchAppAccessToken($twitchClientId, $twitchClientSecret);
        if (is_null($accessToken)) {
            return back()->withErrors(['api_error' => 'Failed to obtain Twitch API access token.']);
        }

        $clipData = $this->getClipDataFromTwitch($twitchClientId, $accessToken, $twitchClipId);
        if (is_null($clipData)) {
            return back()->withErrors(['clip_url' => "Could not find a valid clip with ID '{$twitchClipId}' on Twitch. Please check the ID or URL."]);
        }

        $broadcasterProfileImageUrl = null;
        $clipperProfileImageUrl = null;

        list($broadcasterProfileImageUrl, $clipperProfileImageUrl) =
            $this->getBroadcasterClipperAvatars(
                $twitchClientId, $accessToken,
                $clipData['broadcaster_id'], $clipData['creator_id']
            );

        try {
            Clip::create([
                'twitch_clip_id' => $clipData['id'],
                'title' => $clipData['title'],
                'embed_url' => $clipData['embed_url'],
                'thumbnail_url' => $clipData['thumbnail_url'],
                'views' => $clipData['view_count'],
                'clipper_twitch_id' => $clipData['creator_id'],
                'clipper_name' => $clipData['creator_name'],
                'broadcaster_twitch_id' => $clipData['broadcaster_id'],
                'broadcaster_name' => $clipData['broadcaster_name'],
                'broadcaster_profile_image_url' => $broadcasterProfileImageUrl,
                'clipper_profile_image_url' => $clipperProfileImageUrl,
                'user_id' => Auth::id(),
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while saving the clip. Please try again.']);
        }

        return redirect()->route('dashboard.overview')->with('success', 'Clip submitted successfully!');
    }

    private function extractClipIdFromUrl(string $url): ?string
    {
        $urlParts = parse_url($url);
        $host = $urlParts['host'] ?? '';
        $path = $urlParts['path'] ?? '';

        if (str_contains($host, 'clips.twitch.tv')) {
            return ltrim($path, '/');
        } elseif (str_contains($host, 'www.twitch.tv') && str_contains($path, '/clip/')) {
            $parts = explode('/', $path);
            return end($parts);
        }
        return null;
    }

    private function getTwitchAppAccessToken(string $clientId, string $clientSecret): ?string
    {
        $response = Http::asForm()->post('https://id.twitch.tv/oauth2/token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'client_credentials',
        ]);

        if ($response->successful()) {
            return $response->json('access_token');
        }

        return null;
    }

    private function getClipDataFromTwitch(string $clientId, string $accessToken, string $clipId): ?array
    {
        $response = Http::withHeaders([
            'Client-ID' => $clientId,
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://api.twitch.tv/helix/clips', ['id' => $clipId]);

        if ($response->successful()) {
            return $response->json('data.0');
        }

        return null;
    }

    private function getBroadcasterClipperAvatars(
        string $clientId,
        string $accessToken,
        string $broadcasterId,
        string $clipperId
    ): array {
        $broadcasterProfileImageUrl = null;
        $clipperProfileImageUrl = null;

        $userIdsToFetch = array_unique(array_filter([$broadcasterId, $clipperId]));

        if (empty($userIdsToFetch)) {
            return [null, null];
        }

        $response = Http::withHeaders([
            'Client-ID' => $clientId,
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://api.twitch.tv/helix/users', ['id' => $userIdsToFetch]);

        if ($response->successful()) {
            $usersData = collect($response->json('data'));
            foreach ($usersData as $userData) {
                if ($userData['id'] === $broadcasterId) {
                    $broadcasterProfileImageUrl = $userData['profile_image_url'];
                }
                if ($userData['id'] === $clipperId) {
                    $clipperProfileImageUrl = $userData['profile_image_url'];
                }
            }
        }

        return [$broadcasterProfileImageUrl, $clipperProfileImageUrl];
    }
}