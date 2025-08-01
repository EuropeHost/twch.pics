@extends('layouts.app')

@section('layout-content')
<nav class="bg-gray-800 p-4 text-white flex justify-between items-center">
    <div class="text-xl font-bold">
        <a href="{{ route('dashboard.overview') }}" class="hover:text-gray-300"
            >twch.pics Dashboard</a
        >
    </div>
    <div class="flex items-center space-x-4">
        @if(Auth::check())
        <img
            src="{{ Auth::user()->avatar }}"
            alt="{{ Auth::user()->name }}"
            class="w-8 h-8 rounded-full border-2 border-purple-500"
        />
        <span>{{ Auth::user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                type="submit"
                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-1 px-3 rounded-md flex items-center gap-1"
            >
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
        @endif
    </div>
</nav>

<div class="container mx-auto px-4 py-8">
    @yield('content')
</div>
@endsection