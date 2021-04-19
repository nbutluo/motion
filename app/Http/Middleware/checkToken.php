<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\User\Users;

class checkToken
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
        $result = [];
        $user = Users::find($request->id);
        if ($request->token != $user['api_token']) {
            $result['data']['user']['id'] = $request->id;
            $result['data']['message'] = 'token is wrong';
            return response()->json($result);
        }
        return $next($request);
    }
}
