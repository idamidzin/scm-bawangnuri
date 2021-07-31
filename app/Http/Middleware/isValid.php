<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class isValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->is_valid != NULL || auth()->user()->is_valid != 0)
        {
            return $next($request);
        }
        else
        {
            return redirect()->route('dashboard')->with('msg', ['type'=>'danger','text'=>'Akun anda belum tervalidasi oleh Pabrik !']);
        }
    }
}
