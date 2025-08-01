<div class="bg-white rounded-lg shadow-md p-6 mb-8 text-center">
    @if ($profileUser->profile_image_url)
    <img src="{{ $profileUser->profile_image_url }}" alt="{{ $profileUser->name ?? $profileUser->twitch_id }}"
        class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-purple-500" />
    @endif
    <h1 class="text-3xl font-bold">
        {{ $profileUser->name ?? 'Twitch User' }}
        <span class="text-gray-500 text-xl">({{ $profileUser->twitch_id }})</span>
    </h1>
    @if ($appUser)
    <p class="text-gray-600 mt-2">
        This user has an account on twch.pics ({{ $appUser->name }}).
    </p>
    @endif
    <div class="mt-4 flex justify-center space-x-4">
        <a href="{{ route('users.profile', $profileUser->twitch_id) }}"
            class="px-4 py-2 rounded-md {{ request()->routeIs('users.profile') ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">All Clips</a>
        <a href="{{ route('users.broadcasted', $profileUser->twitch_id) }}"
            class="px-4 py-2 rounded-md {{ request()->routeIs('users.broadcasted') ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">Broadcasted</a>
        <a href="{{ route('users.clipped', $profileUser->twitch_id) }}"
            class="px-4 py-2 rounded-md {{ request()->routeIs('users.clipped') ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">Clipped</a>
        @if ($appUser)
        <a href="{{ route('users.submitted', $profileUser->twitch_id) }}"
            class="px-4 py-2 rounded-md {{ request()->routeIs('users.submitted') ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">Submitted</a>
        @endif
    </div>
</div>