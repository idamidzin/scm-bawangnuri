<?php

namespace App\Http\Middleware;

use Closure;

class VerifyDistributor
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
            return redirect('/distributor');
        }

        if ($user != NULL)
        {
            if (auth()->user()->Role->id == 3 && auth()->auth()->is_valid == 1)
            {
                return $next($request);
            }
            else
            {
                return redirect()->route('no.access')->with('msg', ['type'=>'danger','text'=>'Access Denied']);
            }
        }
        else
        {
            return redirect()->route('dashboard.index')->with('msg', ['type'=>'danger','text'=>'Access Denied']);
        }
        
        return abort('403');
    }
}
