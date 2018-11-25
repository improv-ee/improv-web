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
                    {{ __('auth.email_verification_did_not_receive') }}, <a href="{{ route('verification.resend') }}">{{ __('auth.email_verification_request_another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
