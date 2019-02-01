<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Attention;
use App\Treatments_Detail;
use App\Patients;
use App\Receivable;
use App\Cash;
use Mockery\Exception;
use Validator;
use DateTime;

class CashController extends Controller
{

    public function index(){
        return view('cashier.cash', ['data' => Cash::orderBy('id', 'asc')->get()]);
    }

    public function toRegister($attention_id, $receivable_id){
        $attention = Attention::findOrFail($attention_id);
        $receivable = ($receivable_id == 0) ? 0 : Receivable::findOrFail($receivable_id)->id;
        $treatment_det = Treatments_Detail::where([['procedure_id', $attention->procedure_id],['treatments_id',$attention->treatments_id],['status', 1]])->get();
        return view('cashier.cash-new', ['attention' => $attention, 'receivable'=>$receivable, 'detail'=>$treatment_det]);
    }

    /**
     * Register an item
     * @param Request $request
     * @return redirect to de list of the object
     */
    public function save(Request $request, $attention_id, $receivable_id){

        $return = DB::transaction(function () use ($request, $attention_id, $receivable_id){
            try {

                $cash = new Cash();
                $cash->attention_id = $attention_id;
                $cash->receivable_id = $receivable_id;
                $cash->amount = $request->amount;
                $cash->save();

                Session::push('success', 'Saved data.');
                DB::commit();
                return '/';

            }catch (\Exception $e){
                DB::rollback();
                error_log('Transaction error : '. $e->getMessage());
                Session::push('error','Transaction error.');
                return '/cash/new/'. $attention_id. '/'. $receivable_id;
            }
        });

        return redirect($return);
    }

}
