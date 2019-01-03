<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    /**
     * @param string $username
     * @param string $password
     * @return string
     */
    protected function getToken(string $username, string $password): ?string
    {
        $client = new Client;

        try {
            $response = $client->post(route('passport.token', ['post' => 1]), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => env('OAUTH_API_CLIENT_ID'),
                    'client_secret' => env('OAUTH_API_CLIENT_SECRET'),
                    'username' => $username,
                    'password' => $password,
                    'scope' => '',
                ]
            ]);

            return json_decode($response->getBody())->access_token;
        } catch (ClientException $e) {
            return null;
        }
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
        $token = $this->getToken($request->input('username'), $request->input('password'));

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
