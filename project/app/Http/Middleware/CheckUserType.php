<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $userType)
    {
        if ($request->user()->hasRole($userType)) {
            return $next($request);
        }

        if (in_production()) {
            flash()->error('Acesso não autorizado');
            return redirect()->route('home');
        }

        $message = 'Forbidden Route. ';
        $message .= "This resource was meant for '" . $this->getUserTypeLabel($userType) . "' and ";
        $message .= "you are authenticated as '" . $this->getUserTypeLabel($request->user()->type) . "'.";

        return abort(403, $message);
    }

    private function getUserTypeLabel($userType)
    {
        return $userType;
    }
}
