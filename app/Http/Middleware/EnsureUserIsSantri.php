<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSantri
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isSantri()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki hak sebagai santri.');
        }

        return $next($request);
    }
}
