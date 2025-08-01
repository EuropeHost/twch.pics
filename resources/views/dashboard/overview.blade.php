@extends('layouts.dashboard')

@section('content')
<h1 class="text-3xl font-bold mb-6">
    Welcome to Your Dashboard, {{ $user->name }}!
</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            <i class="bi bi-person-fill"></i> Your Information
        </h2>
        <p><strong>Twitch ID:</strong> {{ $user->twitch_id }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p>
            <strong>Last Login:</strong>
            {{ $user->updated_at->format('M d, Y H:i') }}
        </p>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('users.profile', $user->twitch_id) }}"
                class="inline-block text-sm text-blue-600 hover:underline flex items-center gap-1">
                <i class="bi bi-eye-fill"></i> View Your Public Profile
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            <i class="bi bi-plus-circle-fill"></i> Share a New Clip
        </h2>
        <p class="mb-4">
            Got a great Twitch clip? Share it with the community!
        </p>
        <a href="{{ route('clips.create') }}"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md flex items-center gap-1"
        >
            <i class="bi bi-share-fill"></i> Submit New Clip
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            <i class="bi bi-activity"></i> Your Submitted Clips
        </h2>
        @if ($recentSubmittedClips->isEmpty())
        <p class="text-gray-600">You haven't submitted any clips yet.</p>
        <a href="{{ route('clips.create') }}" class="text-purple-600 hover:underline text-sm">Submit your first clip!</a>
        @else
        <div class="space-y-4">
            @foreach ($recentSubmittedClips as $clip)
                <div class="flex items-center gap-3">
                    <img src="{{ $clip->thumbnail_url }}" alt="{{ $clip->title }}" class="w-16 h-12 object-cover rounded" />
                    <div class="flex-grow">
                        <a href="{{ route('clips.show', $clip->id) }}" class="font-semibold text-gray-900 hover:text-purple-600 line-clamp-1">{{ $clip->title }}</a>
                        <p class="text-gray-600 text-xs">Submitted on {{ $clip->created_at->format('M d, Y') }}</p>
                    </div>
                    <span class="text-gray-700 text-sm flex-shrink-0">
                        {{ $clip->votes->where('is_upvote', true)->count() - $clip->votes->where('is_upvote', false)->count() }} votes
                    </span>
                </div>
            @endforeach
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('users.submitted', $user->twitch_id) }}"
                class="inline-block text-sm text-blue-600 hover:underline flex items-center gap-1">
                <i class="bi bi-collection-fill"></i> View All Your Submitted Clips
            </a>
        </div>
        @endif
    </div>
</div>
@endsection