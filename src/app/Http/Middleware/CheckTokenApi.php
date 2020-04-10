<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class CheckTokenApi
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
        $api_token = !empty($request->header('Api-Token')) ? $request->header('Api-Token') : '';
        if (!empty($api_token)) {
            $user = User::where('api_token',$api_token)->first();
            if (!empty($user->is_admin) && $user->is_admin == 1) {
                return $next($request);
            }
        }

        return response()->json([
            'code' => 401,
            'msg' => 'Mismatch token api',
        ], 401);
    }
}
