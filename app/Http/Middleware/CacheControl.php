<?php

namespace App\Http\Middleware;

use Closure;

class CacheControl
{
    public function handle($request, Closure $next)
    {
        /*
        $response = $next($request);

        //$response->header('Cache-Control', 'no-cache, must-revalidate');

        $headers = [
            'Cache-Control'     => 'no-cache, no-store, must-revalidate, max-age=0, private',
            'Pragma'            => 'no-cache',
            'Expires'           => 'Sun, 02 Jan 1990 00:00:00 GMT'
        ];

        foreach($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
        */
        
        return $next($request)->withHeaders([
            "Pragma" => "no-cache",
            //"Expires" => "Fri, 01 Jan 1990 00:00:00 GMT",
            "Cache-Control" => "no-cache, must-revalidate, no-store, max-age=0, private",
        ]);
    }
}

?>
