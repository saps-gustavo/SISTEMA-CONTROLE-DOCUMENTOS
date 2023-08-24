<?php

namespace App\Http\Middleware;
use Symfony\Component\HttpFoundation\Cookie;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //'cadastro/demanda/*'
    ];

    protected function addCookieToResponse($request, $response)
    {
        $response->headers->setCookie(
            new Cookie('XSRF-TOKEN',
                $request->session()->token(),
                time() + 60 * 120,
                '/',
                config('session.domain'),
                config('session.secure'),
                true, false, 'strict')
        );

        return $response;
    }
}
