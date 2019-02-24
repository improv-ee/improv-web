<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontpage');
    }

    /**
     * Return application config to the frontend
     *
     * Logged in users also get an api token, which enables them to do authenticated requests
     * to the backend API.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getConfig(Request $request)
    {
        return response()
            ->json([
                'token' => $request->session()->get('apiToken'),
                'apiUrl' => sprintf('https://%s/v1', env('API_DOMAIN')),
                'username' => Auth::user()->username ?? null,
                'release' => [
                    'version' => getenv('RELEASE_VERSION', 'dev'),
                    'timestamp' => getenv('RELEASE_TIME', null)
                ]
            ])->withHeaders(['Cache-Control' => 'private']);
    }

    public function maintenance()
    {
        return view('errors.maintenance');
    }
}
