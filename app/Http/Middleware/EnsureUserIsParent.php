<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsParent
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isParent()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki hak sebagai orang tua atau wali santri.');
        }

        return $next($request);
    }
}
