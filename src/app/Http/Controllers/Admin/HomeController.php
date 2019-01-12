<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Orm\OrganizationUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $vueConfig = [
            'token' => $request->session()->get('apiToken'),
            'apiUrl' => sprintf('https://%s/v1', env('API_DOMAIN')),
            'username' => Auth::user()->username ?? null
        ];

        return view('admin/index', ['vueConfig' => $vueConfig]);
    }
}
