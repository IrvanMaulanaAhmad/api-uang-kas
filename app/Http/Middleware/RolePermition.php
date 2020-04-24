<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class RolePermition
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
        if($request->header('api_token')){
            $user = User::where('api_token', $request->header('api_token'))->get();
            if($user->status == 1){
                return $next($request);
            }else{
                return response()->json([
                    'message' => 'you are not allowed to do this Request'
                ]);
            }
        }
        // return $next($request);
    }
}
