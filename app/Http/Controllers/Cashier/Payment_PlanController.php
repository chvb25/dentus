<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Payment_Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;


class Payment_PlanController extends Controller
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
        return view('cashier.payment_plan', ['data' => Payment_Plan::orderBy('id', 'asc')->get()]);
    }
}
