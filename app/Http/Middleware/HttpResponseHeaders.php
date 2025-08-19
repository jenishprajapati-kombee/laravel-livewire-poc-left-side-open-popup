<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class HttpResponseHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! App::environment('local')) {

            //Set Headers
            $response->headers->set('X-Frame-Options', 'DENY', false);
            $response->headers->set('X-Content-Type-Options', 'nosniff', false);
            $response->headers->set('Content-Security-Policy', 'policy', false);
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubdomains; preload',
                false
            );
            $response->headers->set(
                'Permissions-Policy',
                'geolocation=(self)'
            );
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

            // Unset Headers
            /* header_remove('X-Powered-By');
            header_remove('Server'); */
        }

        return $response;
    }
}
