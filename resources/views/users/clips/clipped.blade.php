@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    @include('users._profile_header', ['profileUser' => $profileUser, 'appUser' => $appUser])

    <h2 class="text-2xl font-bold mb-6 text-center">Clips Clipped by {{ $profileUser->name ?? $profileUser->twitch_id }}</h2>

    @if ($clips->isEmpty())
    <p class="text-center text-gray-600">No clips clipped by this user found.</p>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($clips as $clip)
            @include('components._clip_card', ['clip' => $clip, 'aspectRatio' => 'aspect-w-4 aspect-h-3'])
        @endforeach
    </div>

    <div class="mt-8">
        {{ $clips->links() }}
    </div>
    @endif
</div>
@endsection