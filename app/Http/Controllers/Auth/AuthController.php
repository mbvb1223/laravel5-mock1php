<?php

namespace App\Http\Controllers\Auth;

use App\Users;
use Validator;
use libraries\Authen;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Contracts\Auth\Authenticatable;
use Mail;

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
    use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
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
            'email' => 'required|email|max:255|unique:users',
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
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'avatar' => $data['avatar'],
            'status' => Users::INACTIVE,
            'role_id' => Users::MEMBER,
            'keyactive'=>md5(time()),
            'password' => bcrypt($data['password']),
        ]);
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $this->create($request->all());

        $inputUsername = $this->getCredentials($request)['username'];
        //Get info User, this User have just registry
        $user = new Users();
        $userInfo = $user->where('username', $inputUsername)->first()->toArray();

        //Sent mail to this user for active account
        Mail::send('mail.welcome', ['userInfo' => $userInfo], function($message) use ($userInfo)
        {
            $message->subject("Welcome to khienpc");
            $message->to($userInfo['email']);
        });

        Authen::setUser($userInfo);
        //Authen::setUser($request->all());
        //Auth::login($this->create($request->all()),$remember = false);
        Auth::attempt($this->getCredentials($request), $remember = true);

        return redirect($this->redirectPath());
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
            $user = new Users();
            $userInfo = $user->where('username', $inputUsername)->first();

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

}
