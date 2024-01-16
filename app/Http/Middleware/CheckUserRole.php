<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            $user = (new User)::findOrFail(Auth::id());
            $route_name = $request->route()->getName();
            $role_priorities = $user->roles()->pluck('priority')->toArray();

            if(($route_name==='roles.index' || $route_name==='role.store' || $route_name==='user.role.update') && in_array(1, $role_priorities)){
                return $next($request);
            }
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }
}
