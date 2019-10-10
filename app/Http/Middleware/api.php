<?php

namespace App\Http\Middleware;

use App\Models\Token;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class api
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
//    public function handle($request, Closure $next, $guard = null)
//    {
//        if (Auth::guard($guard)->check()) {
//            return $next($request);
//        }
//        return response()->json(['status'=>'login']);
//    }
    public function handle($request, Closure $next, $guard = null)
    {
        if (request()->header('Authorization'))
        {
            $token = Token::where('api_token', request()->header('Authorization'))->first();

            if ($token)
            {
                $user = User::where('id', $token->user_id)->first();

                if ($user && $user->status == 1)
                {
                    return $next($request);
                }
                else
                {
                    $data = [
                        'status' => false,
                        'message' => __('api.UserBlocked'),
                        'date' => null
                    ];
                    return response()->json($data);
                }
            }
        }

        $data = [
            'status' => false,
            'message' => __('api.Authorization'),
            'date' => null
        ];
        return response()->json($data);
    }
}
















