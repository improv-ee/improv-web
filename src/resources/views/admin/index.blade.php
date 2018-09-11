@extends('layouts.app')
@section('title', 'improv.ee')

@section('topright')
    <a class="btn btn-sm btn-outline-secondary mr-3" href="#">{{ Auth::user()->name }}</a>
    <form action="{{ url('/logout') }}" method="POST">
        {!! csrf_field() !!}
        <button type="submit" class="btn btn-sm btn-outline-secondary">
            {{ __('auth.logout') }}
        </button>
    </form>
@endsection

@section('content')
    <div id="app"></div>
@endsection


@section('scripts')
    <script src="{{ asset('js/admin/app.js') }}"></script>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css') }}" />
@endsection
