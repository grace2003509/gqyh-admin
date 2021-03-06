<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class CheckRole
{

    protected $auth;


    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    public function handle($request, Closure $next,$roles)
    {
        if ($this->auth->guest() || !$request->user()->hasRole(explode('|', $roles))) {
//            abort(403);
            return redirect()->route('admin.home')->withErrors('您没有权限访问!!!');
        }
        return $next($request);
    }
}
