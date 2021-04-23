<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$permission)
    {
        if (app('auth')->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        // 权限判断，若是 root 用户则不需要判断
        if (auth()->user()->hasAnyRole(['root'])) {
            return $next($request);
        }

        // 获取权限列表
        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        // 当有一个权限不满足就报异常
        foreach ($permissions as $permission) {
            if (!app('auth')->user()->can($permission)) {
                throw UnauthorizedException::forPermissions($permissions);
//                return response(['message' => '没有权限'], 403);
            }
        }

        return $next($request);
    }
}
