<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return (current_user()->is_admin)
            ? redirect()->route('admin.dashboard.index')
            : redirect()->route('client.dashboard.index');
    }
}
