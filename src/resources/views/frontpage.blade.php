@extends('layouts.app')
@section('title', isset($title)?$title:strtolower(config('app.name')))

@section('topright')
    <div class="btn-group" role="group" aria-label="{{ __('auth.login') }}">
        @guest
            <a class="btn btn-sm btn-primary" href="{{ route('login') }}">{{ __('auth.login') }}</a>
        @else
            <form action="{{ url('/logout') }}" method="POST">

                <a class="btn btn-sm btn-primary" href="{{ route('home') }}">{{ Auth::user()->name }}</a>
                {!! csrf_field() !!}
                <button type="submit" title="{{ __('auth.logout') }}" class="btn btn-sm btn-light">
                    <i class="far fa-times-circle"></i>
                </button>
            </form>
        @endguest
    </div>
@endsection

@section('content')
    <div id="app"></div>
@endsection

@section('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}"/>
@endsection
