<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
      /**
       * Handle an incoming request.
       *
       * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
       */
      public function handle(Request $request, Closure $next): Response
      {
            if (!isset($_SESSION['user'])) {
                  return to_route('login');
            }
            return $next($request);
      }
}
