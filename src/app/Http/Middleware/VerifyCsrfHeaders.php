<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VerifyCsrfHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (app()->isProduction() && !$request->isMethod('get')) {
            if (!Str::startsWith($request->header('Origin'), config('app.url'))) {
                return response('Bad Request', 400);
            }

            if ($request->header('Sec-Fetch-Site') !== 'same-origin') {
                return response('Bad Request', 400);
            }
        }

        return $next($request);
    }
}
