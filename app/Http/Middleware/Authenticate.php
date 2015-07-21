<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\libraries\Authen;
use Lang;
use View;

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

        if ($this->auth->guest()) {

            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth/login');
            }
        }
        if (Authen::checkStatus() == false) {
            return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.no_active'));
        }
        if (Authen::checkLoginToBackEnd() == false) {
            return redirect()->action('FrontendController@index')->withErrors(Lang::get('messages.do_not_permission'));
        }
        if (Authen::checkPermission() == false) {
            return view('errors.disable');
        }
        return $next($request);
    }
}
