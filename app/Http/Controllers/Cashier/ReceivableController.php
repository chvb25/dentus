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
use App\Payment_Plan;
use Mockery\Exception;
use Validator;
use DateTime;

class ReceivableController extends Controller
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

    public function toRegister($attention_id){
        $attention = Attention::findOrFail($attention_id);
        $treatment_det = Treatments_Detail::where([['procedure_id', $attention->procedure_id],['treatments_id',$attention->treatments_id],['status', 1]])->get();
        return view('cashier.receivable-new', ['attention' => $attention, 'detail'=>$treatment_det]);
    }

    /**
     * Register an item
     * @param Request $request
     * @return redirect to de list of the object
     */
    public function save(Request $request, $attention_id){

        $return = DB::transaction(function () use ($request, $attention_id){
            try {
                $date = DateTime::createFromFormat('d/m/Y', $request->date);
                $usableDate = $date->format('Y-m-d');

                $receivable = new Receivable();
                $receivable->attention_id = $attention_id;
                $receivable->amount = $request->total;
                $receivable->debt = $request->total;
                $receivable->first_date = $usableDate;
                $receivable->periodicity = $request->periodicity;
                $receivable->quotas = $request->quota;
                $receivable->installments = $request->quota;
                $receivable->save();

                $item = 1;
                foreach ($request->dynamic as $items) {
                    if (count($request->dynamic) == 1 && $items == "") break;
                    $values = \explode('|', $items);
                    $firstDate = DateTime::createFromFormat('Y-m-d', substr($values[0], 0, 10));
                    $usableDate = $firstDate->format('Y-m-d');
                    $q_detail = new Payment_Plan();
                    $q_detail->id = $item;
                    $q_detail->receivable_id = $receivable->id;
                    $q_detail->date = $usableDate;
                    $q_detail->amount = $values[1];
                    $q_detail->save();
                    $item++;
                }

                Session::push('success', 'Se ha realizado el registro correctamente.');
                DB::commit();
                return '/main';

            }catch (\Exception $e){
                DB::rollback();
                error_log('Error en la transaccion : '. $e->getMessage());
                Session::push('error','Error en la transacción.');
                return '/receivable/new/'. $attention_id;
            }
        });

        return redirect($return);
    }
}
