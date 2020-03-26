<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dashboard view')->only(['index']);
    }

    public function index()
    {
        return view('client.dashboard.index');
    }
}
