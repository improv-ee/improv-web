@extends('frontpage')

@section('content')

    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <div class="card">

                <h5 class="card-header info-color white-text text-center py-4">
                    <strong>{{ __('auth.login') }}</strong>
                </h5>

                <div class="card-body px-lg-5 pt-0">

                    <form class="text-center" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="md-form">
                            <label for="materialLoginFormEmail">{{ __('user.email') }}</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="md-form">
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                   required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                            <label for="materialLoginFormPassword">{{ __('user.password') }}</label>
                        </div>


                        <button class="btn btn-primary btn-rounded btn-block my-4 waves-effect z-depth-0"
                                type="submit">   {{ __('auth.login') }}</button>

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('auth.forgot_password') }}
                        </a>
                        <a class="btn btn-link" href="{{ route('register') }}">{{ __('auth.register') }}</a>
                    </form>

                </div>
            </div>
        </div>

    </div>



@endsection
