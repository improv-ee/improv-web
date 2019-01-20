<?php

namespace App\Http\Controllers\Auth;

use App\Auth\BearerToken;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        login as public parentLogin;
        logout as public parentLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * @var BearerToken
     */
    protected $bearerToken;

    /**
     * Create a new controller instance.
     *
     * @param BearerToken $bearerToken
     */
    public function __construct(BearerToken $bearerToken)
    {
        $this->middleware('guest')->except('logout');
        $this->bearerToken = $bearerToken;
    }

    public function username()
    {
        return 'username';
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::user()->tokens->each(function (Token $token, $key) {
            $token->delete();
        });

        return $this->parentLogout($request);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {

        // This does the "traditional" Laravel login
        $response = $this->parentLogin($request);

        // We won't continue unless normal auth succeeded
        if (Auth::user() === null) {
            return $response;
        }

        // Now, get a new Passport API Bearer token for the logged in user
        $token = $this->bearerToken->getToken($request->input('username'), $request->input('password'));

        // Fetching API token failed, no point of continuing
        if ($token === null) {
            Auth::logout();
            return redirect('/login');
        }
        // API token is stored in session, for use in subsequent requests (by the frontend)
        $request->session()->put('apiToken', $token);

        return $response;
    }
}
