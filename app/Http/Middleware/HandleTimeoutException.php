<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleTimeoutException
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (\Throwable $e) {
            if (str_contains($e->getMessage(), 'Maximum execution time') || 
                str_contains($e->getMessage(), 'execution time exceeded')) {
                
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'error' => 'timeout',
                        'message' => 'La requête a pris trop de temps à s\'exécuter.',
                        'reload' => true
                    ], 408);
                }
                
                return response()->view('errors.timeout', [], 408);
            }
            
            throw $e;
        }
    }
}