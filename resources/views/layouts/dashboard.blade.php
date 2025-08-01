@extends('layouts.app')

@section('layout-content')
@include('components.navbar')

<div class="container mx-auto px-4 py-8">
    @yield('content')
</div>
@endsection