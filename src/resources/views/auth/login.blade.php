@extends('frontpage')

@section('content')

    <div class="row mt-5">
        <div class="col-12 col-md-6 offset-md-3">
            <div class="card">

                <h5 class="card-header info-color white-text text-center py-4">
                    <strong>{{ __('auth.login') }}</strong>
                </h5>

                <div class="card-body px-lg-5 pt-0">

                    <form class="text-center" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="md-form">
                            <label for="username">{{ __('user.username') }}</label>
                            <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                   name="username" value="{{ old('username') }}" required autofocus maxlength="32">
                            @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
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

            <p class="alert alert-info mt-5">
                Improvision on hetkel avatud beta-testimises. See tähendab, et süsteem on uus - esineb puudusi ning vigu.
                Kui märkad viga, palun anna sellest meile teada. Palume testperioodil mõistvat suhtumist!
            </p>
        </div>

    </div>



@endsection
