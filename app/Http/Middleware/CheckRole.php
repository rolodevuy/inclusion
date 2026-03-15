<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user() || ! $request->user()->hasRole($role)) {
            abort(403, 'No tenés permiso para acceder a esta sección.');
        }

        if (! $request->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Tu cuenta ha sido desactivada.');
        }

        return $next($request);
    }
}
