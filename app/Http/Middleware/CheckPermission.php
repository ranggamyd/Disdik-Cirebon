<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $menu, $access)
	{
		if(auth()->user()->isHasPermission($menu, $access)) {
			return $next($request);
		}

		if($request->ajax()) {
			abort(404);
		} else {
			return redirect('login');
		}
	}
}
