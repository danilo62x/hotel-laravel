<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateMock
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('user')) {
            return redirect()->route('login', ['redirect' => '/'.ltrim($request->path(), '/')]);
        }
        return $next($request);
    }
}
