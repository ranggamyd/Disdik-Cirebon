<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }

        if (auth()->user()->role == 'Anggota') {
            return url('/');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        if (auth()->user()->role == 'Anggota') {
            return redirect('/');
        }

        return $next($request);
    }

}
