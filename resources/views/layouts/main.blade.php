@extends('layouts.app')

@section('layout-content')
@include('components.navbar')
@yield('content')
@include('components.footer')
@endsection