<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!in_array($user->role, $roles, true)) {
            return response()->json(['errors' => ['authorization' => 'Anda tidak memiliki akses ke data ini']], 403);
        }

        return $next($request);
    }
}
