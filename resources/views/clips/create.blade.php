<!-- resources/views/clips/create.blade.php -->
@extends('layouts.dashboard') @section('content')
<h1 class="text-3xl font-bold mb-6">Submit a New Twitch Clip</h1>

<div class="bg-white rounded-lg shadow-md p-6 max-w-xl mx-auto">
    @if ($errors->any())
    <div
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
        role="alert"
    >
        <strong class="font-bold">Oops!</strong>
        <span class="block sm:inline">Please fix the following errors:</span>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif @if (session('success'))
    <div
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
        role="alert"
    >
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('clips.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label
                for="clip_url"
                class="block text-gray-700 text-sm font-bold mb-2"
                >Twitch Clip URL (Optional):</label
            >
            <input
                type="url"
                name="clip_url"
                id="clip_url"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('clip_url') border-red-500 @enderror"
                placeholder="e.g., https://www.twitch.tv/user/clip/ClipNameHere"
                value="{{ old('clip_url') }}"
            />
            @error('clip_url')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label
                for="clip_id_direct"
                class="block text-gray-700 text-sm font-bold mb-2"
                >Direct Twitch Clip ID (Optional):</label
            >
            <input
                type="text"
                name="clip_id_direct"
                id="clip_id_direct"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('clip_id_direct') border-red-500 @enderror"
                placeholder="e.g., ovMT5BglzDIdH_yx"
                value="{{ old('clip_id_direct') }}"
            />
            @error('clip_id_direct')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative text-sm" role="alert">
            <p>Please provide *either* a Clip URL *or* a Direct Clip ID (or both). If both are provided, the Direct Clip ID will take precedence.</p>
        </div>

        <div class="flex items-center justify-between">
            <button
                type="submit"
                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center gap-2"
            >
                <i class="bi bi-upload"></i> Submit Clip
            </button>
        </div>
    </form>
</div>
@endsection