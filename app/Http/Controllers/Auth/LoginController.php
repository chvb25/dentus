<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Auth;
use App\Setting;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(){
        return view('auth.login', ['users_count'=> User::all()->count()]);
    }

    public function login(Request $request){
        // create our user data for the authentication
        $userData = array(
            'username' => $request->username,
            'password' => $request->password
        );
        $setting = Setting::first();
        Session::put('settings',$setting);
        // attempt to do the login
        if (Auth::attempt($userData)) {
            if (Auth::user()->status  == 0) {
                Session::push('info','El usuario "'. Auth::user()->username. '" se encuentra inactivo.');
                Auth::logout();
                return redirect('/');
            }
            return redirect('main');
        } else {
            Session::push('warning','Combinación incorrecta de nombre de usuario y contraseña.');
            return redirect('/');
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
