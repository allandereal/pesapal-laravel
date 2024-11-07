<?php

namespace AllanDereal\PesaPal\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class PesaPalWebhookMiddleware
{
    public function handle(Request $request, ?Closure $next = null)
    {
        try {
            //
        } catch (Exception $e) {
            abort(400, $e->getMessage());
        }

        return $next($request);
    }
}
