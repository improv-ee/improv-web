<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\App;
use Laravel\Passport\Client as OauthClient;

abstract class TokenProviderController extends Controller
{
    /**
     * @param string $username
     * @param string $password
     * @return string
     */
    protected function getToken(string $username, string $password): ?string
    {

        // Skip token creating when unittests are running
        // External HTTP call will not pass
        if (App::environment() === 'testing') {
            return 'testing';
        }

        $client = new Client;

        // Use the first available password grant client

        $oauthClient = OauthClient::where('password_client', 1)
            ->where('user_id', null)
            ->where('revoked', 0)
            ->orderBy('id','asc')
            ->firstOrFail();

        try {
            $response = $client->post(route('passport.token', ['post' => 1]), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $oauthClient->id,
                    'client_secret' => $oauthClient->secret,
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
}