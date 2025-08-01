@props(['clip', 'aspectRatio' => 'aspect-w-16 aspect-h-9'])
<div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
    <a href="{{ route('clips.show', $clip->id) }}" class="block">
        <div class="relative {{ $aspectRatio }} bg-black">
            <img
                src="{{ $clip->thumbnail_url }}"
                alt="{{ $clip->title }}"
                class="absolute inset-0 w-full h-full object-cover object-center"
            />
            <div
                class="absolute bottom-0 left-0 bg-gradient-to-t from-black via-transparent to-transparent p-2 w-full"
            >
                <span class="text-white text-xs font-semibold"
                    >{{ number_format($clip->views) }} views</span
                >
            </div>
        </div>
    </a>
    <div class="p-4 flex flex-col flex-grow">
        <h2 class="text-xl font-semibold mb-2 line-clamp-2">
            <a
                href="{{ route('clips.show', $clip->id) }}"
                class="hover:text-purple-600"
            >
                {{ $clip->title }}
            </a>
        </h2>
        <div class="text-gray-600 text-sm mb-3">
            <p>
                From:
                <a
                    href="{{ route('users.broadcasted', $clip->broadcaster_twitch_id) }}"
                    class="font-medium text-purple-600 hover:underline"
                >
                    {{ $clip->broadcaster_name }}
                </a>
                @if ($clip->broadcaster_profile_image_url)
                <img
                    src="{{ $clip->broadcaster_profile_image_url }}"
                    alt="{{ $clip->broadcaster_name }}"
                    class="inline-block w-4 h-4 rounded-full ml-1"
                />
                @endif
            </p>
            <p>
                Clipped by:
                <a
                    href="{{ route('users.clipped', $clip->clipper_twitch_id) }}"
                    class="font-medium text-blue-600 hover:underline"
                >
                    {{ $clip->clipper_name }}
                </a>
                @if ($clip->clipper_profile_image_url)
                <img
                    src="{{ $clip->clipper_profile_image_url }}"
                    alt="{{ $clip->clipper_name }}"
                    class="inline-block w-4 h-4 rounded-full ml-1"
                />
                @endif
            </p>
            @if ($clip->user)
            <p>
                Submitted by:
                <a
                    href="{{ route('users.submitted', $clip->user->twitch_id) }}"
                    class="text-green-600 hover:underline"
                >
                    {{ $clip->user->name }}
                </a>
                on {{ $clip->created_at->format('M d, Y') }}
            </p>
            @else
            <p class="text-gray-500">Submitted on {{ $clip->created_at->format('M d, Y') }}</p>
            @endif
        </div>

        <div class="mt-auto flex justify-between items-center pt-2 border-t border-gray-100">
            <div class="flex items-center gap-2">
                <span class="text-lg font-bold text-gray-800">
                    {{ $clip->votes->where('is_upvote', true)->count() - $clip->votes->where('is_upvote', false)->count() }}
                </span>
                <i class="bi bi-arrow-up-circle-fill text-green-500"></i>
                <i class="bi bi-arrow-down-circle-fill text-red-500"></i>
                <span class="text-sm text-gray-500">view to vote</span>
            </div>
            <a
                href="{{ route('clips.show', $clip->id) }}"
                class="text-sm text-purple-600 hover:underline flex items-center gap-1"
            >
                View Clip <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>