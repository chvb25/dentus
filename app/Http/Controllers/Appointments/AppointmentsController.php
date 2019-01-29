<?php

namespace App\Http\Controllers\Appointments;

use App\Http\Controllers\Controller;
use App\Appointments;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use Validator;
use DateTime;

class AppointmentsController extends Controller
{
    public function index(){
        return view('appointments.appointments', ['data' => Appointments::orderBy('date', 'asc')->orderBy('start_time', 'asc')->get()]);
    }    

    public function toRegister(){
        return view('appointments.appointments-new');
    }

    public  function toUpdate($id){
        $appointment = Appointments::findOrFail($id);     
        return view('appointments.appointments-edit', ['appointment' => $appointment]);
    }


    /**
     * Register an item
     * @param Request $request
     * @return reditect to de list of the object
     */
    public function save(Request $request){
        $this->validateData($request, '/appointments/new');

        $return = DB::transaction(function () use ($request){            
            try {
                $date = DateTime::createFromFormat('d/m/Y', $request->date);        
                $usableDate = $date->format('Y-m-d');
                
                $appointment = new Appointments();
                $appointment->treatments_id = $request->patient_id;
                $appointment->procedure_id = 0;
                $appointment->date = $usableDate;                
                $appointment->start_time = $request->startTime;
                $appointment->end_time = $request->endTime;                
                $appointment->status = 0;
                $appointment->save();                               

                Session::push('success', 'Saved data.');
                DB::commit();
                return '/appointments';

            }catch (\Exception $e){
                DB::rollback();
                error_log('Transaction error : '. $e->getMessage());
                Session::push('error','Transaction error.');                
                return '/appointments/new/';
            }
        });

        return redirect($return);
    }
    
    /**
     * Register an item
     * @param Request $request
     * @return reditect to de list of the object
     */
    public function saveWithTreatment(Request $request){        
        error_log('save : '. $request);

        $return = DB::transaction(function () use ($request){            
            try {
                $date = DateTime::createFromFormat('d/m/Y', $request->date_t);        
                $usableDate = $date->format('Y-m-d');
                
                $splitId = explode('-', $request->procedures);

                $appointment = new Appointments();
                $appointment->treatments_id = $splitId[1];
                $appointment->procedure_id = $splitId[0];
                $appointment->date = $usableDate;                
                $appointment->start_time = $request->startTime_t;
                $appointment->end_time = $request->endTime_t;                
                $appointment->status = 0;
                $appointment->save();                               

                Session::push('success', 'Saved data.');
                DB::commit();
                return '/appointments';

            }catch (\Exception $e){
                DB::rollback();
                error_log('Transaction error : '. $e->getMessage());
                Session::push('error','Transaction error.');                
                return '/appointments/new/';
            }
        });


        return redirect($return);
    }

    /**
     * Update an item
     * @param Request $request
     * @param $id
     * @return reditect to de list of the object
     */
    public function update(Request $request, $id){
        $this->validateData($request, '/appointments-edit/'. $id);

        $return =DB::transaction(function () use ($request, $id){
            try {
                $date = DateTime::createFromFormat('d/m/Y', $request->date);        
                $usableDate = $date->format('Y-m-d');
                
                $appointment = Appointments::findOrFail($id);
                $appointment->treatments_id = $request->treatments_id;
                $appointment->procedure_id = 0;
                $appointment->date = $usableDate;                
                $appointment->start_time = $request->startTime;
                $appointment->end_time = $request->endTime;                
                $appointment->status = 0;
                $appointment->save();      

                Session::push('success', 'Saved data.');
                DB::commit();
                return '/appointments';
            }catch (Exception $e){
                Session::push('error','Transaction error.');
                DB::rollback();
                return '//appointments-edit/'. $id;
            }
        });

        return redirect($return);
    }

    /**
     * Update an item
     * @param Request $request
     * @param $id
     * @return reditect to de list of the object
     */
    public function updateWithTreatment(Request $request, $id){
        
        $return =DB::transaction(function () use ($request, $id){
            try {
                $date = DateTime::createFromFormat('d/m/Y', $request->date_t);        
                $usableDate = $date->format('Y-m-d');                
                $splitId = explode('-', $request->procedures);                             

                $appointment = Appointments::findOrFail($id);
                $appointment->treatments_id = $splitId[1];
                $appointment->procedure_id = $splitId[0];
                $appointment->date = $usableDate;                
                $appointment->start_time = $request->startTime_t;
                $appointment->end_time = $request->endTime_t;                
                $appointment->status = 0;
                $appointment->save();      

                Session::push('success', 'Saved data.');
                DB::commit();
                return '/appointments';
            }catch (Exception $e){
                Session::push('error','Transaction error.');
                DB::rollback();
                return '//appointments-edit/'. $id;
            }
        });

        return redirect($return);
    }

    /**
     * Update an item
     * @param Request $request
     * @param $id
     * @return reditect to de list of the object
     */
    public function reschedule(Request $request, $id){
        
        $return =DB::transaction(function () use ($request, $id){
            try {
                $date = DateTime::createFromFormat('d/m/Y', $request->date);        
                $usableDate = $date->format('Y-m-d');
                
                $appointment = Appointments::findOrFail($id);                
                $appointment->date = $usableDate;                
                $appointment->start_time = $request->startTime;
                $appointment->end_time = $request->endTime;                
                $appointment->save();

                Session::push('success', 'Saved data.');
                DB::commit();
                return '/';
            }catch (Exception $e){
                Session::push('error','Transaction error.');
                DB::rollback();
                return '/';
            }
        });

        return redirect($return);
    }

    /**
     * Update an item
     * @param Request $request
     * @param $id
     * @return reditect to de list of the object
     */
    public function cancel($id){
        
        $return =DB::transaction(function () use ($id){
            try {
                                
                $appointment = Appointments::findOrFail($id);                
                $appointment->status = 2;
                $appointment->save();

                Session::push('success', 'Saved data.');
                DB::commit();
                return '/';
            }catch (Exception $e){
                Session::push('error','Transaction error.');
                DB::rollback();
                return '/';
            }
        });

        return redirect($return);
    }

    /**
     * Delete an item
     * @param $id
     * @return reditect to de list of the object
     */
    public function delete($id){
        if(Appointments::where('id','=', $id)->first() === null){
            Session::push('error','Element not found.');
        }else{
            $return =DB::transaction(function () use ($id){
                try {                    
                    Appointments::where('id', '=', $id)->delete();
                    Session::push('success','Deleted data.');
                    DB::commit();
                    return '/appointments';
                }catch (Exception $e){
                    Session::push('error','Transaction error.');
                    DB::rollback();
                    return '//appointments/';
                }
            });
            return redirect($return);
        }
    }

    public function listByDate(Request $request){
        try{
            $date = Appointments::where('date', '=', $request->input('query'))->orderBy('start_time', 'asc')->get();
            return new JsonResponse($date);
        } catch (\Throwable $th) {            
            error_log($th->getMessage());
        }   
    }

    /**
     * Validate the options at the page
     * @param Request $request
     * @param array $redirect
     * @return mixed the path to be redirected with errors
     */
    private function validateData(Request $request, $redirect){
        $validator = Validator::make($request->all(),
            ['name'=>'required|min:5|max:50', 'date'=>'required|date|date_format:d/m/Y', 
            'startTime' => 'required|date_format:H:i', 'endTime' => 'required|date_format:H:i']);
        if($validator->fails()){
            Session::push('error','message');
            return redirect($redirect)->withInput()->withErrors($validator);
        }
    }
}

