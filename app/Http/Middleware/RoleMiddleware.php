<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        if (Auth::guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        // 角色判断，若是 root 用户则不需要判断
        if (auth()->user()->hasAnyRole(['root'])) {
            return $next($request);
        }

        // 获取角色列表
        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        if (! Auth::user()->hasAnyRole($roles)) {
            throw UnauthorizedException::forRoles($roles);
        }

        return $next($request);
    }
}
