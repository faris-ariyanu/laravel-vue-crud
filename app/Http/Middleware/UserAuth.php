<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!isset($_SERVER['HTTP_KEY'])){  

            return response()->json(["status"=>false,
                                    "message"=>"access forbidden"],401);  
        } 
        else
        {
            $key    = $_SERVER['HTTP_KEY'];

            $VerifyAuth     = User::where('remember_token', '=', $key)
                                ->where("status",1)
                                ->count();
            if(!$VerifyAuth)
            {
                return response()->json(["status"=>false,
                                    "message"=>"access forbidden, wrong token"],401);  
            }
        }

        return $next($request);
    }
}
