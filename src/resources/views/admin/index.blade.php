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
    Logged in
@endsection


