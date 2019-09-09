<?php

namespace App\Http\Controllers\SingleInvokes;

use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return redirect()->route('home');
    }
}
