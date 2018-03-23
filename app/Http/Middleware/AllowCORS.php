<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;

class AllowCORS implements Middleware {

		/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $response = $next($request);
        // Do stuff
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
	}

}
