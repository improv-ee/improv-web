@extends('layouts.app')
@section('title', config('app.name'))

@section('topright')
    <div class="btn-group" role="group" aria-label="{{ __('auth.login') }}">
    <a class="btn btn-sm btn-primary" href="#/profile/settings">{{ Auth::user()->name }}</a>
    <form action="{{ url('/logout') }}" method="POST">
        {!! csrf_field() !!}
        <button type="submit" class="btn btn-sm btn-primary">
            {{ __('auth.logout') }}
        </button>
    </form>
    </div>
@endsection

@section('content')
    <div id="app">
        @include('loading')
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('js/admin/app.js') }}"></script>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css') }}" />
@endsection
