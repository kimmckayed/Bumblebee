<?php namespace App\Http\Middleware;


use Log;
use Closure;
use Illuminate\Contracts\Routing\TerminableMiddleware;

class LogAfterRequest implements TerminableMiddleware
{

    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {

      if(str_contains($request->path(),'integration')){
          Log::info('integration.requests', ['request' => $request->all(), 'response' => $response->getContent()]);
      }


    }


}
