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
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            <i class="bi bi-activity"></i> Recent Activity
        </h2>
        <p class="text-gray-600">No recent activity to display yet.</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            <i class="bi bi-plus-circle-fill"></i> Share a New Clip
        </h2>
        <p class="mb-4">
            Got a great Twitch clip? Share it with the community!
        </p>
        <a
            href="#"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md flex items-center gap-1"
        >
            <i class="bi bi-share-fill"></i> Share Clip (Coming Soon!)
        </a>
    </div>
</div>
@endsection