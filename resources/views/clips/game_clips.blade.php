@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Clips for Game: {{-- Game Name Here --}}</h1>

    @if ($clips->isEmpty())
    <p class="text-center text-gray-600">No clips found for this game yet.</p>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($clips as $clip)
        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
            <a href="{{ route('clips.show', $clip->id) }}" class="block">
                <img src="{{ $clip->thumbnail_url }}" alt="{{ $clip->title }}"
                    class="w-full h-48 object-cover object-center" />
            </a>
            <div class="p-4 flex flex-col flex-grow">
                <h2 class="text-xl font-semibold mb-2 line-clamp-2">
                    <a href="{{ route('clips.show', $clip->id) }}" class="hover:text-purple-600">
                        {{ $clip->title }}
                    </a>
                </h2>
                <div class="text-gray-600 text-sm mb-3">
                    <p>Clipped by:
                        <span class="font-medium">{{ $clip->clipper_name }}</span>
                    </p>
                    <p>From:
                        <span class="font-medium">{{ $clip->broadcaster_name }}</span>
                    </p>
                    <p>Submitted by:
                        <a href="#" class="text-blue-600 hover:underline">
                            {{ $clip->user->name }}
                        </a>
                        on {{ $clip->created_at->format('M d, Y') }}
                    </p>
                    <p>Views: <span class="font-medium">{{ number_format($clip->views) }}</span></p>
                </div>

                <div class="mt-auto flex justify-between items-center pt-2 border-t border-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-bold text-gray-800">
                            {{ $clip->votes->where('is_upvote', true)->count() - $clip->votes->where('is_upvote', false)->count() }}
                        </span>
                        <i class="bi bi-arrow-up-circle-fill text-green-500"></i>
                        <i class="bi bi-arrow-down-circle-fill text-red-500"></i>
                    </div>
                    <a href="{{ route('clips.show', $clip->id) }}"
                        class="text-sm text-purple-600 hover:underline flex items-center gap-1">
                        View Clip <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $clips->links() }}
    </div>
    @endif
</div>
@endsection