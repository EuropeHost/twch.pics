@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-center">Leaderboards</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <a href="{{ route('leaderboards.clips') }}" class="block bg-white rounded-lg shadow-md p-6 text-center hover:bg-gray-50 transition">
            <h2 class="text-xl font-semibold text-purple-600 mb-2">Top Clips</h2>
            <p class="text-gray-600">See the most popular clips by net votes.</p>
        </a>
        <a href="{{ route('leaderboards.broadcasters') }}" class="block bg-white rounded-lg shadow-md p-6 text-center hover:bg-gray-50 transition">
            <h2 class="text-xl font-semibold text-purple-600 mb-2">Top Broadcasters</h2>
            <p class="text-gray-600">Discover channels with the most viewed clips.</p>
        </a>
        <a href="{{ route('leaderboards.clippers') }}" class="block bg-white rounded-lg shadow-md p-6 text-center hover:bg-gray-50 transition">
            <h2 class="text-xl font-semibold text-purple-600 mb-2">Top Clippers</h2>
            <p class="text-gray-600">Find the users who captured the best moments.</p>
        </a>
        <a href="{{ route('leaderboards.submitters') }}" class="block bg-white rounded-lg shadow-md p-6 text-center hover:bg-gray-50 transition">
            <h2 class="text-xl font-semibold text-purple-600 mb-2">Top Submitters</h2>
            <p class="text-gray-600">See who submits the most clips to twch.pics.</p>
        </a>
    </div>

    <h2 class="text-2xl font-bold mb-6 text-center">Top 10 Clips Right Now</h2>
    @if ($topClips->isEmpty())
        <p class="text-center text-gray-600">No clips available for the leaderboard yet.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($topClips as $clip)
                @include('components._clip_card', ['clip' => $clip, 'aspectRatio' => 'aspect-w-4 aspect-h-3'])
            @endforeach
        </div>
    @endif
</div>
@endsection