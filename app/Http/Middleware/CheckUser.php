<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use PeterPetrus\Auth\PassportToken;
use App\User;
use Closure;

class CheckUser
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
        $is_user = false;
        if($header != null){
            $token = new PassportToken($header);
            if ($token->valid) {   
                if ($token->existsValid()) {
                    $prop = $token->getProperties();
                    $revoke = \DB::table('oauth_access_tokens')->where('id',$prop['token_id'])->first();
                    if($revoke && !$revoke->revoked){
                        return $next($request);
                    }
                }
            }
        }
        return redirect('/auth/login');
    }
}
