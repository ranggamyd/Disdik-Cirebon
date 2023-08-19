<?php

namespace App\Http\Middleware;

use Closure;

class CheckApiKey
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(!empty($request->api_key))
		{
			$apiKey = \Setting::getValue('api_key', 'API_KEY');
			if($request->api_key == $apiKey)
			{
				return $next($request);
			}
		}

		return \Res::invalid([
			'message'	=> 'Invalid request'
		]);
	}
}
