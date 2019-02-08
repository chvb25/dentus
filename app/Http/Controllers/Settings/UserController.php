<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('setting.users', ['data'=> User::where('id', '>', '1')->get()]);
    }

    public function toRegister(){
        return view('setting.user-new');
    }


    public function toUpdate($id){
        $user = User::findOrFail($id);
        return view('setting.user-edit', ['user' => $user]);
    }

    public function viewProfile(){
        if (\Auth::user()->id == 1) {
            Session::push('warning','No puede modificar la cuenta administrador.');
            return redirect()->to('main');
        }else{
            $user = User::findOrFail(\Auth::user()->id);
            return view('setting.user', ['user' => $user]);
        }
    }

    public function save(Request $request){
        $return = DB::transaction(function () use ($request){
            try{
                $user = $this->create([$request->name, $request->username, $request->password]);
                Session::push('success', 'Se ha realizado el registro correctamente.');
                DB::commit();
                return '/users';
            }catch (\Exception $e){
                DB::rollback();
                error_log('Error en la transaccion : '. $e->getMessage());
                Session::push('error','Error en la transacción.');
                return '/user/new/';
            }
        });
        return redirect($return);
    }

    public function update(Request $request, $id){
        $return = DB::transaction(function () use ($request, $id){
            try{
                $user = User::findOrFail($id);
                $user->name = $request->name;
                $user->username = $request->username;
                $user->status = ($request->status) ? 1 : 0;
                if ($request->profile == 1) {
                    if($request->new_password != ""){
                        if (!(Hash::check($request->current_password, $user->password))) {
                            Session::push('info', 'Su contraseña actual no coincide con la contraseña que usted proporcionó. Por favor, inténtalo de nuevo.');
                            return 'user-edit/'. $id;
                        }
                        $user->password = $request->new_password;
                    }
                }
                $user->save();
                Session::push('success', 'Se ha actualizado el registro correctamente.');
                DB::commit();
                return '/users';
            }catch (\Exception $e){
                DB::rollback();
                error_log('Error en la transaccion : '. $e->getMessage());
                Session::push('error','Error en la transacción : '. $e->getMessage());
                return 'user-edit/'. $id;
            }
        });
        return redirect($return);
    }
}
