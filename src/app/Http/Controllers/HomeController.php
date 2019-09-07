<?php

namespace App\Http\Controllers;


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

    public function maintenance()
    {
        return view('errors.maintenance');
    }
}
