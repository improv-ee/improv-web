@extends('layouts.app')
@section('title', config('app.name'))

@section('topright')
    <div class="btn-group" role="group" aria-label="{{ __('auth.login') }}">
    @guest
        <a class="btn btn-sm btn-primary" href="{{ route('login') }}">{{ __('auth.login') }}</a>
        <a class="btn btn-sm btn-primary" href="{{ route('register') }}">{{ __('auth.register') }}</a>
    @else
        <a class="btn btn-sm btn-primary" href="{{ route('home') }}">{{ Auth::user()->name }}</a>
    @endguest
    </div>
@endsection

@section('content')
            <div id="app"></div>
@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" />
@endsection