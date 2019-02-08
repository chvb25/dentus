<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class SettingController extends Controller
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
        return view('setting.setting', ['setting' => Setting::first()]);
    }

    public function save(Request $request){
        try {
            $setting = Setting::first();
            $setting->clinic_name = $request->name;
            $setting->clinic_address = $request->address;
            $setting->currency = $request->currency;
            $setting->symbol = $request->symbol;
            $setting->tax = $request->tax;
            $setting->save();

            $settings = Setting::first();
            Session::put('settings', $settings);

            Session::push('success','Se ha actualizado el registro correctamente.');
            return redirect('main');
        } catch (\Throwable $th) {
            error_log('Error en la transaccion : '. $th->getMessage());
            Session::push('error',$th->getMessage());
            return redirect('/setting');;
        }

    }
}
