<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'adminLogin', 'showAdminLoginForm');
        $this->middleware('guest:admin')->except('logout', 'userLogin', 'showUserLoginForm');
        $this->middleware('guest:web')->except('logout', 'adminLogin', 'showAdminLoginForm');
    }

    /**
     * 管理者ログイン用
     */
    public function showAdminLoginForm()
    {
        return view('auth.login', ['authgroup' => 'admin']);
    }

    public function adminLogin(AdminLoginRequest $request)
    {
        $this->validate($request, [
            'login_id'   => 'required',
            'password' => 'required|min:8'
        ]);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if (Auth::guard('admin')->attempt(['login_id' => $request->login_id, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('/admin/');
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return back()->withInput($request->only('email', 'remember'))->with(['error_message' => 'Tài khoản hoặc mật khẩu không chính xác']);
    }

    public function showUserLoginForm()
    {
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }

        return view('front.home.login');
    }

    public function userLogin(Request $request)
    {
        $this->validate($request, [
            'email_login'   => 'required',
            'password_login' => 'required|min:8'
        ]);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if (Auth::guard('web')->attempt(['email' => $request->email_login, 'password' => $request->password_login], $request->get('remember'))) {
            if(isset($request->another_login) && !is_null($request->another_login))
            {
                return redirect()->intended(url()->previous());
            }
            return redirect()->intended('/');
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return back()->withInput($request->only('email_login', 'remember'))->with(['error_message' => 'Email or password is incorrect']);
    }

}
