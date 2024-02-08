<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ... $roles): Response
    {
        if (Auth::check()) {
            foreach ($roles as $rol) {
                if (Auth::user()->hasRole($rol)) {
                    return $next($request);
                }
            }
        }
        throw new UnauthorizedException('Forbidden.');
    }
}
