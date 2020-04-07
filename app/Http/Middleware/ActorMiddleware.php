<?php

namespace App\Http\Middleware;

use Closure;

class ActorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$actors)
    {
        if (!empty($request->user())) {
            if ($request->user()->hasAnyActors($actors)) {
                return $next($request);
            }
            abort(401, 'Tidak memiliki izin.');
        }
        return redirect('login');
    }
}
