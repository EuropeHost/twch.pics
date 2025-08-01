<!-- resources/views/clips/show.blade.php -->
@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 pb-0">
            <h1 class="text-3xl font-bold mb-4">{{ $clip->title }}</h1>

            <div class="flex items-center space-x-4 mb-4 text-gray-700 text-sm">
                @if ($clip->broadcaster_profile_image_url)
                <img src="{{ $clip->broadcaster_profile_image_url }}" alt="{{ $clip->broadcaster_name }}"
                    class="w-8 h-8 rounded-full" />
                @endif
                <span>From: <strong class="text-purple-600">{{ $clip->broadcaster_name }}</strong></span>

                @if ($clip->clipper_profile_image_url)
                <img src="{{ $clip->clipper_profile_image_url }}" alt="{{ $clip->clipper_name }}"
                    class="w-8 h-8 rounded-full" />
                @endif
                <span>Clipped by: <strong>{{ $clip->clipper_name }}</strong></span>
            </div>

            <div class="mb-4 text-gray-600 text-sm">
                <p>Submitted by:
                    <a href="#" class="text-blue-600 hover:underline">
                        {{ $clip->user->name }}
                    </a>
                    on {{ $clip->created_at->format('M d, Y H:i') }}
                </p>
                <p>Views: <span class="font-medium">{{ number_format($clip->views) }}</span></p>
            </div>
        </div>

        <div class="aspect-w-16 aspect-h-9 w-full bg-black">
            <iframe
                src="{{ $clip->embed_url }}&parent={{ config('app.url') ? parse_url(config('app.url'), PHP_URL_HOST) : 'localhost' }}"
                height="720"
                width="1280"
                frameborder="0"
                scrolling="no"
                allowfullscreen="true"
                class="w-full h-full"
            ></iframe>
        </div>

        <div class="p-6 border-t border-gray-200 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <span class="text-2xl font-bold text-gray-800">
                    {{ $clip->votes->where('is_upvote', true)->count() - $clip->votes->where('is_upvote', false)->count() }}
                </span>
                <form action="{{ route('clips.vote', $clip->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="upvote">
                    <button type="submit"
                        class="text-green-500 hover:text-green-700 text-3xl transition-colors duration-200">
                        <i class="bi bi-arrow-up-circle-fill"></i>
                    </button>
                </form>
                <form action="{{ route('clips.vote', $clip->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="downvote">
                    <button type="submit"
                        class="text-red-500 hover:text-red-700 text-3xl transition-colors duration-200">
                        <i class="bi bi-arrow-down-circle-fill"></i>
                    </button>
                </form>
            </div>

            <div class="text-gray-500 text-sm">
                <i class="bi bi-chat-fill"></i> {{ $clip->comments->count() }} Comments
            </div>
        </div>

        <div class="p-6 border-t border-gray-200">
            <h3 class="text-xl font-bold mb-4">Comments</h3>

            @auth
            <form action="{{ route('clips.comments.store', $clip->id) }}" method="POST" class="mb-8">
                @csrf
                <div class="mb-4">
                    <textarea name="content" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('content') border-red-500 @enderror"
                        placeholder="Write your comment here..." required>{{ old('content') }}</textarea>
                    @error('content')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Post Comment
                </button>
            </form>
            @else
            <p class="mb-4 text-gray-600">
                <a href="{{ route('login') }}" class="text-purple-600 hover:underline">Log in with Twitch</a> to post a comment.
            </p>
            @endauth

            @php
                $topLevelComments = $clip->comments->whereNull('parent_id')->sortByDesc('created_at');
            @endphp

            @if ($topLevelComments->isEmpty())
            <p class="text-gray-600">No comments yet. Be the first to comment!</p>
            @else
            <div class="space-y-6">
                @foreach ($topLevelComments as $comment)
                    @include('clips._comment', ['comment' => $comment])
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection