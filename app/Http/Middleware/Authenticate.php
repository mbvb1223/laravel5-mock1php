<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use libraries\Authen;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        if(Authen::checkLogin() == false) {
//            return redirect('auth/login');
//        }
//        if(Authen::checkPermission() == false) {
//            return view('errors.access_deny');
//        }
//        return $next($request);
//    }
        if ($this->auth->guest()) {

            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth/login');
            }
        }

        if (Authen::checkPermission() == false) {
            return view('errors.disable');
        }
        return $next($request);
    }
}
