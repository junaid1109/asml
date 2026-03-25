<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure($request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (\Illuminate\Support\Facades\Auth::guard($guard)->check()) {
                return redirect('/home');
            }
        }

        return $next($request);
    }
}
