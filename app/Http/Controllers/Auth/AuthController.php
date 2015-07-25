<?php

namespace App\Http\Controllers\Auth;

use App\City;
use App\Region;
use App\User;
use App\Users;
use Validator;
use App\libraries\Authen;
use App\Order;
use App\libraries\ReCaptcha;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Session;
use App\Category;
use Illuminate\Support\Facades\Redirect;
use Mail;
use Lang;
use View;

class AuthController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    public $username = 'username';
    public $redirectPath = 'admin/home';
    public $loginPath = 'auth/login';
    public $redirectTo = 'admin/users';
    use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);


        /**
         * Get menu header
         */
        $categories = Category::all()->toArray();
        foreach ($categories as $value) {
            $pa                 = $value['parent'];
            $menuConvert[$pa][] = $value;
        }
        $parent  = 0;
        $topMenu = "";
        if ($categories == null) {
            $menuConvert = null;
        }
        Callmenu($menuConvert, $parent, $topMenu);
        $sidebar = "";
        getSideBarForFrontEnd($menuConvert, $parent, $sidebar);

        //=========================================View Cart in Index===================================================
        $sessionOrder = Session::get('order');
        if (!empty($sessionOrder)) {
            $convertAndSortSessionOrder = convertAndSortByKeySessionCart($sessionOrder);
            $objOrder                   = new Order();
            $getViewCartInIndexFrontEnd = $objOrder->getViewCartInIndexFrontEnd($convertAndSortSessionOrder)[0];
            $countSessionCart           = count($sessionOrder);
            $totalCost                  = $objOrder->getViewCartInIndexFrontEnd($convertAndSortSessionOrder)[1];
        } else {
            $getViewCartInIndexFrontEnd = null;
            $countSessionCart           = 0;
            $totalCost                  = 0;
        }
        //=========================================View Cart in Index===================================================
        $getViewUserInIndexFrontEnd = Users::getViewUserInIndexFrontEnd();

        View::share(array(
            "menu"                       => $topMenu,
            "sidebar"                    => $sidebar,
            'getViewCartInIndexFrontEnd' => $getViewCartInIndexFrontEnd,
            "countSessionCart"           => $countSessionCart,
            "totalCost"                  => $totalCost,
            "getViewUserInIndexFrontEnd" =>$getViewUserInIndexFrontEnd,
        ));
    }

    public function getLogout()
    {
        Auth::logout();
        Session::forget('user');
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
    public function getRegister()
    {
        $getViewSelectTagCity   = City::getViewSelectTagCity();
        $mapIdCityToArrayRegion = Region::mapIdCityToArrayRegion();
        return view('auth.register')->with([
            'getViewSelectTagCity'   => $getViewSelectTagCity,
            'mapIdCityToArrayRegion' => $mapIdCityToArrayRegion,
        ]);
    }

    public function postRegister(Request $request)
    {
        $allRequest = $request->all();
        $recaptcha  = $allRequest['g-recaptcha-response'];

        if ($recaptcha == null) {
            return redirect('auth/register')->withErrors(Lang::get('messages.recaptcha_fail'))
                ->withInput();
        }


        $secret   = "6LcrigkTAAAAAILxkngAvRl77FEm4mpEWYvi4XNA";
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptcha);
        $res      = json_decode($response, true);

        if ($res['success']) {

            $validator = $this->validator($allRequest);
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
            $this->create($request->all());

            $inputUsername = $this->getCredentials($request)['username'];
            //Get info User, this User have just registry
            $user     = new Users();
            $userInfo = $user->where('username', $inputUsername)->first()->toArray();

            //Sent mail to this user for active account
            Mail::send('mail.welcome', ['userInfo' => $userInfo], function ($message) use ($userInfo) {
                $message->subject("Welcome to khienpc");
                $message->from('khienpc.sosc@gmail.com');
                $message->to($userInfo['email']);
            });

            Authen::setUser($userInfo);
            Auth::attempt($this->getCredentials($request), $remember = true);

            return redirect($this->redirectPath());
        } else {
            return redirect('auth/register')->withErrors(Lang::get('messages.recaptcha_fail'))
                ->withInput();
        }


    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255|unique:users',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return Users::create([
            'username'  => $data['username'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'avatar'    => $data['avatar'],
            'status'    => Users::INACTIVE,
            'role_id'   => Users::MEMBER,
            'keyactive' => md5(time()),
            'address'   => $data['address'],
            'city_id'   => $data['city_id'],
            'region_id' => $data['region_id'],
            'password'  => bcrypt($data['password']),
        ]);
    }


    public function postLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        $throttles = in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }


        if (Auth::attempt($this->getCredentials($request), $request->has('remember'))) {
            // Get info this userLogin

            $inputUsername = $this->getCredentials($request)['username'];
            $user          = new Users();
            $userInfo      = $user->where('username', $inputUsername)->first();

            Authen::setUser($userInfo);
            if ($throttles) {
                $this->clearLoginAttempts($request);
            }

            return redirect()->intended($this->redirectPath());
            //return redirect('admin/users');
        }

        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }
    public function postLoginToBuy(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        $throttles = in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }


        if (Auth::attempt($this->getCredentials($request), $request->has('remember'))) {
            // Get info this userLogin

            $inputUsername = $this->getCredentials($request)['username'];
            $user          = new Users();
            $userInfo      = $user->where('username', $inputUsername)->first();

            Authen::setUser($userInfo);
            if ($throttles) {
                $this->clearLoginAttempts($request);
            }
            return Redirect::back()->withSuccess(Lang::get('messages.login_success'));
        }else {
            return Redirect::back()->withErrors(Lang::get('messages.login_false'));
        }
    }

}
