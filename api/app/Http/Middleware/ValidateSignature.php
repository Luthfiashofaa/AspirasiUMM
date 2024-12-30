<?php
namespace App\Http\Middleware;

use Closure;

class ValidateSignature
{
    public function handle($request, Closure $next)
    {
        // Implementasi middleware
        return $next($request);
    }
}
