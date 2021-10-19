<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;

class CheckLogin
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
        try{
            $header = $request->cookie('adventure_karo');
        }catch(\Exception $ex){
            return redirect('/auth/login');
        }
        if($header == null){
            return $next($request);         
        }
        return redirect('/v1');
    }
}
