<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use PeterPetrus\Auth\PassportToken;
use App\User;

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
        }else{
            $token = new PassportToken($header);
            if ($token->valid) {
                if ($token->existsValid()) {     
                    $prop = $token->getProperties();
                    $revoke = \DB::table('oauth_access_tokens')->where('id',$prop['token_id'])->first();
                    if($revoke && !$revoke->revoked){
                        $user = User::find($token->user_id);
                        if($user->role == 'admin')
                            return redirect('/v1');
                        else if($user->role == 'vendor')
                            return redirect('/v2');
                        else abort(401);
                    }
                }
            }
            return redirect('/auth/login');
        }
    }
}
