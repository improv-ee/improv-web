@extends('layouts.app')
@section('title', config('app.name'))

@section('topright')
    <div class="btn-group" role="group" aria-label="{{ __('auth.login') }}">
    <a class="btn btn-sm btn-primary" href="#/profile/settings">{{ Auth::user()->name }}</a>
    <form action="{{ url('/logout') }}" method="POST">
        {!! csrf_field() !!}
        <button type="submit" title="{{ __('auth.logout') }}" class="btn btn-sm btn-light">
            <i class="far fa-times-circle"></i>
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
    <script src="{{ mix('js/admin/app.js') }}"></script>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin.css') }}" />
@endsection
