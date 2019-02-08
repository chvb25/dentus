<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:191',
            'username' => 'required|string|max:191|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data[0],
            'username' => $data[1],
            'password' => $data[2],
        ]);
    }

    public function register(Request $request){
        $return = DB::transaction(function () use ($request){
            try{
                $this->validator([$request->name, $request->username, $request->password]);
                $user = $this->create([$request->name, $request->username, $request->password]);
                auth()->login($user);
                $setting = Setting::first();
                Session::put('settings',$setting);
                Session::push('info', 'Se ha registrado un nuevo usuario.');
                DB::commit();
                return 'main';
            }catch (\Exception $e){
                DB::rollback();
                error_log('Error en la transaccion : '. $e->getMessage());
                Session::push('error','No se ha completado la transacción.');
                return '/';
            }
        });
        return redirect($return);
    }
}
