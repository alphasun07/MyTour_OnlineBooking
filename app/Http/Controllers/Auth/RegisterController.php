<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Controller;
use App\Jobs\CheckMailRegister;
use App\Models\PcmDmsConfig;
use App\Providers\RouteServiceProvider;
use App\Models\PcmMember;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PcmUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
        $this->middleware('guest:web');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function Validator($data)
    {
        return Validator::make($data, [
            'name'                      => ['required', 'string', 'max:255'],
            'password'                  => ['required', 'string', 'min:8'],
            'password_confirmation'     => ['required', 'string', 'same:password'],
            'email'                     => ['required', 'email', 'max:255', Rule::unique('pcm_users', 'email', 'deleted_at')->withoutTrashed()],
            'email_confirm'             => ['required', 'email', 'same:email'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return PcmMember::create($data);
    }

    public function showUserRegisterForm()
    {
        return view('front.home.register', ['authgroup' => 'admin']);
    }

    protected function createUser(array $data)
    {
        return PcmUser::create($data);
    }

    public function userRegister(Request $request)
    {
        $this->Validator($request->all())->validate();

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        event(new Registered($user = $this->createUser($data)));

        Auth::guard('web')->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect(route('front.home'));
    }

    protected function registered(Request $request, $user)
    {
    }
}
