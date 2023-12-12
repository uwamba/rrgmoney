<?php

namespace App\Http\Middleware;
use Spatie\Permission\Traits\hasPermissions;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $permission = null, $guard = null)
    {
        $authGuard = app('auth')->guard($guard);
       // dd($role);

        if ($authGuard->guest()) {

            throw UnauthorizedException::notLoggedIn();
        }

        if (! is_null($permission)) {
            //dd($permission);

            $permissions = is_array($permission)
                ? $permission
                : explode('|', $permission);
                //dd($permissions);

        }

        if ( is_null($permission) ) {
            //dd('welcome2');
            $permission = $request->route()->getName();
            //dd($permission);
            $permissions = array($permission);

        }


        foreach ($permissions as $permission) {
           // dd('welcome3');
            if ($authGuard->user()->can($permission)) {
                return $next($request);

            }
        }
       // dd('welcome4');
        throw UnauthorizedException::forPermissions($permissions);
    }
}
