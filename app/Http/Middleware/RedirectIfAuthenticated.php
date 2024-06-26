<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                //determin weather role redirect to his route
                if (Auth::user()->hasRole('user')) {
                    //for users
                    return redirect(RouteServiceProvider::PROFILE);
                } elseif (Auth::user()->hasRole('admin')) {
                    // for admin and organize
                    return redirect(RouteServiceProvider::ADMIN);
                } elseif (Auth::user()->hasRole('organizer')) {
                    // for admin and organize
                    return redirect(RouteServiceProvider::ORGANIZER);
                }
            }
        }

        return $next($request);
    }
}
