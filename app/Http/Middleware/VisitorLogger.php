<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\VisitorLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class VisitorLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $this->logVisitor($request, $response);

        return $response;
    }

    private function logVisitor(Request $request, Response $response)
    {
        $visitorLog = new VisitorLog();
        $visitorLog->user_id = auth()->user()->id ?? null;
        $visitorLog->ip = $request->ip();
        $visitorLog->endpoint = $request->path();
        $visitorLog->accessed_at = now();
        $visitorLog->save();

        Redis::incr("hits:endpoint:{$visitorLog->endpoint}");
        Redis::incr("hits:daily:" . $visitorLog->accessed_at->format('Y-m-d'));
    }
}
