<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {
        if (!Auth::check()) 
            return redirect('login');
        foreach ($roles as $role) {
            if(Auth::user()->role == $role){
                return $next($request);
            }
        }
        return redirect('404')->with('msg', '404 page Not found');
        
    }
}
