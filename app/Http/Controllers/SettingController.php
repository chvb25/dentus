<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Illuminate\Support\Facades\Session;
use Validator;

class SettingController extends Controller
{
    public function index(){
        return view('setting.setting', ['setting' => Setting::first()]);
    }

    public function save(Request $request){
        $setting = Setting::first();
        $setting->clinic_name = $request->name;
        $setting->clinic_address = $request->address;
        $setting->currency = $request->currency;
        $setting->symbol = $request->symbol;
        $setting->tax = $request->tax;
        $setting->save();
        return redirect('/');
    }
}
