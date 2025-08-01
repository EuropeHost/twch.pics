@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Leaderboard: Top Broadcasters</h1>

    @if ($broadcasters->isEmpty())
    <p class="text-center text-gray-600">No broadcasters found for this leaderboard yet.</p>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($broadcasters as $broadcaster)
        <div class="bg-white rounded-lg shadow-md p-4 text-center flex flex-col items-center">
            <a href="{{ route('users.profile', $broadcaster->broadcaster_twitch_id) }}">
                @if ($broadcaster->broadcaster_profile_image_url)
                <img src="{{ $broadcaster->broadcaster_profile_image_url }}" alt="{{ $broadcaster->broadcaster_name }}"
                    class="w-24 h-24 rounded-full mb-3 border-2 border-purple-500" />
                @else
                <div class="w-24 h-24 rounded-full mb-3 bg-gray-300 flex items-center justify-center text-gray-600 text-3xl">
                    <i class="bi bi-person-fill"></i>
                </div>
                @endif
            </a>
            <h2 class="text-xl font-semibold mb-1">
                <a href="{{ route('users.profile', $broadcaster->broadcaster_twitch_id) }}" class="hover:text-purple-600">
                    {{ $broadcaster->broadcaster_name }}
                </a>
            </h2>
            <p class="text-gray-600 text-sm">Total Clips: <span class="font-medium">{{ number_format($broadcaster->total_clips) }}</span></p>
            <p class="text-gray-600 text-sm">Total Views: <span class="font-medium">{{ number_format($broadcaster->total_views) }}</span></p>
            <a href="{{ route('users.broadcasted', $broadcaster->broadcaster_twitch_id) }}"
                class="mt-3 text-sm text-blue-600 hover:underline flex items-center gap-1">
                View all clips <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $broadcasters->links() }}
    </div>
    @endif
</div>
@endsection