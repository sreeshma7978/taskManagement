<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequestExecutionTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Start measuring time
        $startTime = microtime(true);

        // Proceed with the request
        $response = $next($request);

        // Calculate the execution time
        $executionTime = microtime(true) - $startTime;

        // Log the execution time
        Log::error('Request to ' . $request->url() . ' executed in ' . round($executionTime, 3) . ' seconds.');

        return $response;
    }
}
