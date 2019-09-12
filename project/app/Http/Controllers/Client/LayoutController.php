<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class LayoutController extends Controller
{
    public function index()
    {
        $layouts = collect([
            asset('assets/img/example-layout.png'),
            asset('assets/img/example-layout.png'),
            asset('assets/img/example-layout.png'),
            asset('assets/img/example-layout.png'),
            asset('assets/img/example-layout.png'),
            asset('assets/img/example-layout.png')
        ]);

        return view('client.sites.layouts.index', compact('layouts'));
    }
}
