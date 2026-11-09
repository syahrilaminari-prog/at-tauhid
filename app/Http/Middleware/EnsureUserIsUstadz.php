<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsUstadz
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isUstadz()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki hak sebagai ustadz.');
        }

        return $next($request);
    }
}
