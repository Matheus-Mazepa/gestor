<?php

namespace App\Http\Controllers;

use App\Enums\UserRolesEnum;

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
        return (current_user()->hasRole(UserRolesEnum::ADMIN))
            ? redirect()->route('admin.users.index')
            : redirect()->route('client.users.index');
    }
}
