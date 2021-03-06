<?php

namespace App\Http\Middleware;

use Closure;

/**
 * CheckRoleAgent.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class CheckRoleAgent
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->role == 'agent' || $request->user()->role == 'admin') {
            return $next($request);
        }

        return redirect('/')->with('fails', 'You are not Authorised');
    }
}
