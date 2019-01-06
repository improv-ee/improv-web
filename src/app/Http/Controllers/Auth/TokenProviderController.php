<?php

namespace App\Http\Controllers\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

use App\Http\Controllers\Controller;

abstract class TokenProviderController extends Controller {
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
}