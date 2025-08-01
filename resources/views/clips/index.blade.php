@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Browse Latest Clips</h1>

    @if ($clips->isEmpty())
    <p class="text-center text-gray-600">
        No clips found yet. Be the first to
        <a href="{{ route('clips.create') }}" class="text-purple-600 hover:underline">submit one</a>!
    </p>
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