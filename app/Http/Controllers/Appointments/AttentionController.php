<?php

namespace App\Http\Controllers\Appointments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Attention;
use App\Appointments;
use App\Treatments;
use App\Treatments_Detail;
use App\Procedures;
use App\Patients;
use Mockery\Exception;
use Validator;
use DateTime;


class AttentionController extends Controller
{      

    public function index(){
        return view('appointments.attention', ['data' => Attention::orderBy('date', 'asc')->get()]);
    }    

    public function toRegister($id){
        $appointment = Appointments::findOrFail($id);             
        return view('appointments.attention-new', ['appointment' => $appointment]);
    }

    public  function toUpdate($id){
        $appointment = Attention::findOrFail($id);     
        return view('appointments.attention-edit', ['appointment' => $appointment]);
    }

    /**
     * Register an item
     * @param Request $request
     * @return reditect to de list of the object
     */
    public function save(Request $request, $id){        

        $return = DB::transaction(function () use ($request, $id){            
            try {
                               
                $appointment = Appointments::findOrFail($id);
                $appointment->status = 1;
                $appointment->save();

                $attention = new Attention();
                $attention->treatments_id = $appointment->treatments_id;
                $attention->procedure_id = $appointment->procedure_id;
                $attention->patient_id = $appointment->patientId;
                $attention->date = $appointment->date;
                $attention->tooth = $request->tooth;
                $attention->status = $request->status;
                $attention->save();       

                if($appointment->procedure_id > 0){                       
                    $treatment_detail = Treatments_Detail::where([['treatments_id', '=', $appointment->treatments_id], ['procedure_id', '=',$appointment->procedure_id]])->first();
                    $treatment_detail->status = $request->status;
                    $treatment_detail->save();

                    //verifying if all the procedures are complete
                    $treatment_detail = Treatments_Detail::where('treatments_id', '=', $appointment->treatments_id)->get();
                    $complete = true;
                    foreach ($treatment_detail as $item) {
                        $complete = $complete && ($item->status == 1);                            
                    }

                    $treatment = Treatments::findOrFail($appointment->treatments_id);
                    $treatment->status = ($complete) ? 1 : 2;
                    $treatment->save(); 
                }

                Session::push('success', 'Saved data.');
                DB::commit();
                return '/';

            }catch (\Exception $e){
                DB::rollback();
                error_log('Transaction error : '. $e->getMessage());
                Session::push('error','Transaction error.');                
                return '/attention/new/'. $id;
            }
        });

        return redirect($return);
    }
}
