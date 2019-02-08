<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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

    public function reset(Request $request){
        $return = DB::transaction(function () use ($request){
            try{
                $user = User::where('username', $request->username)->first();
                if($user === null){
                    Session::push('error','No se ha encontrado el usuario.');
                }else{
                    if ($user->id == 1) {
                        Session::push('error','No se puede modificar la contraseña del administrador.');
                    }else{
                        $user->password = '123456';
                        $user->save();
                        Session::push('success', 'Se ha restaurado su contraseña.');
                        DB::commit();
                    }
                }
                return '/';
            }catch (\Exception $e){
                DB::rollback();
                error_log('Error en la transaccion : '. $e->getMessage());
                Session::push('error','No se ha restaurado la contraseña.');
                return '/';
            }
        });
        return redirect($return);
    }
}
