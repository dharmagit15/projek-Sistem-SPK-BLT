<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
        public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah user sudah login dan apakah rolenya admin
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, tendang kembali ke landing page atau halaman lain
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}
