<?php

namespace App\Http\Middleware;

use Closure;

class ApiLumenMiddleware
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
        //si no existe el header api-key
        if( ! $request->header("api-key") )
        {
            return response()->json(['message' => "You cannot access this resource"], 403);
        }
        //si la api key es distinta de la api-key que hemos definido en el .env
        if( $request->header( "api-key" ) != env( "API_KEY" ) )
        {
            return response()->json(['message' => "You cannot access this resource with this credentials"], 401);
        }
        return $next($request);
    }
}
