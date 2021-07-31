<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerifyUser
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
        $user = $request->user();

        if (!auth()->check()) 
        {
            return redirect('/');
        }


        if ($user != NULL) {
            return $next($request);
        }else{
            return redirect()->route('dashboard.index')->with('msg', ['type'=>'danger','text'=>'Access Denied']);
        }

        return abort('403');
    }
}
