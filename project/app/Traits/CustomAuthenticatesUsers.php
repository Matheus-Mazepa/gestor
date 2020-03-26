<?php

namespace App\Traits;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use App\Enums\UserRolesEnum;
use App\Models\User;

trait CustomAuthenticatesUsers
{
    use AuthenticatesUsers;

    protected function attemptLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user)
        {
            $this->guard()->attempt(
                $this->credentials($request), $request->filled('remember')
            );
        }

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }
}
