<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForumGuestMessage
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            session()->flash('message', 'Forum\'u görmek için giriş yapmalısınız.');
        }

        return $next($request);
    }
}
