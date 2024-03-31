<?php

namespace App\Http\Middleware;

use Closure;

class BlockRoute
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
        // Check if the request is accessing the register route
        if ($request->is('register')) {
            // Redirect or abort the request as needed
            return redirect('/'); // Redirect to homepage
            // Or you can abort the request with an error message
            // abort(403, 'Access denied');
        }

        // Allow the request to proceed to the next middleware
        return $next($request);
    }
}
