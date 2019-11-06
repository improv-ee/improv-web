@extends('frontpage')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('auth.verify_email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('auth.email_verification_resent') }}
                        </div>
                    @endif

                    {{ __('auth.email_verification_needed') }}

                        {{ __('auth.email_verification_did_not_receive') }}
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf

                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                            {{ __('auth.email_verification_request_another') }}
                        </button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
