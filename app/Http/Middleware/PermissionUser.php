<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class PermissionUser
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
        $user = User::find($request->user_id);

        if(!$user) {
            return response()->json([
                'messagem' => 'User does not exist'
            ],404);
        }

        if(count($user->permission) == 0) {
            return response()->json([
                'messagem' => 'Unauthorized user'
            ],401);
        }

        foreach($user->permission as $permission) {
            if($permission->desc == 'admin' | $permission->desc == 'user-manager') {
                return $next($request);
            }else {
                return response()->json([
                    'messagem' => 'Unauthorized user'
                ],401);
            }
        }
    }
}
