<?php

namespace App\Http\Controllers\Procedure;

use App\Http\Controllers\Controller;
use App\Procedures;
use App\Treatments;
use App\Treatments_Detail;
use App\Patients;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;
use DateTime;

class TreatmentsController extends Controller
{

    public function index(){
        return view('procedures.treatments', ['data' => Treatments::orderBy('id', 'asc')->get()]);
    }

    public function toRegister(){
        return view('procedures.treatments-new', ['procedures' => Procedures::orderBy('id', 'asc')->get()]);
    }

    public  function toUpdate($id){
        $treatment = Treatments::findOrFail($id);
        $procedures_id = Treatments_Detail::where('treatments_id', '=', $id)->select('procedure_id')->get();
        return view('procedures.treatments-edit', ['treatment' => $treatment,
            'procedures' => DB::table('procedures')->whereNotIn('id', $procedures_id)->get(),
            'detail'=> DB::table('treatments_detail')->join('procedures', 'treatments_detail.procedure_id', '=', 'procedures.id')
            ->where('treatments_detail.treatments_id','=',$id)->select('procedures.*')->get()]);
    }

    /**
     * Register an item
     * @param Request $request
     * @return redirect to de list of the object
     */
    public function save(Request $request){
        $this->validateData($request, '/treatments/new');

        $return = DB::transaction(function () use ($request){
            try {
                $date = DateTime::createFromFormat('d/m/Y', $request->date);
                $usableDate = $date->format('Y-m-d');

                $treatments = new Treatments();
                $treatments->patients_id = $request->patient_id;
                $treatments->quote_id = 0;
                $treatments->date = $usableDate;
                $treatments->sub_total = $request->subtotal;
                $treatments->discount = $request->discount;
                $treatments->final_price = $request->total;
                $treatments->status = 0;
                $treatments->save();

                $item = 1;
                foreach ($request->dynamic as $items) {
                    if (count($request->dynamic) == 1 && $items == "") break;
                    $values = \explode('-', $items);
                    $q_detail = new Treatments_Detail();
                    $q_detail->id = $item;
                    $q_detail->treatments_id = $treatments->id;
                    $q_detail->procedure_id = $values[0];
                    $q_detail->price = $values[1];
                    $q_detail->save();
                    $item++;
                }

                Session::push('success', 'Saved data.');
                DB::commit();
                return '/treatments';

            }catch (\Exception $e){
                DB::rollback();
                error_log('Transaction error : '. $e->getMessage());
                Session::push('error','Transaction error.');
                return '/treatments/new/';
            }
        });


        return redirect($return);
    }

    /**
     * Update an item
     * @param Request $request
     * @param $id
     * @return redirect to de list of the object
     */
    public function update(Request $request, $id){
        $this->validateData($request, '/treatments-edit/'. $id);

        $return =DB::transaction(function () use ($request, $id){
            try {
                $date = DateTime::createFromFormat('d/m/Y', $request->date);
                $usableDate = $date->format('Y-m-d');

                $treatments = Treatments::findOrFail($id);
                $treatments->patients_id = $request->patient_id;
                $treatments->quote_id = $request->quote_id;
                $treatments->date = $usableDate;
                $treatments->sub_total = $request->subtotal;
                $treatments->discount = $request->discount;
                $treatments->final_price = $request->total;
                $treatments->status = $request->status;
                $treatments->save();

                Treatments_Detail::where('treatments_id', '=', $id)->delete();
                $item = 1;
                foreach ($request->dynamic as $items) {
                    if (count($request->dynamic) == 1 && $items == "") break;
                    $values = \explode('-', $items);
                    $q_detail = new Treatments_Detail();
                    $q_detail->id = $item;
                    $q_detail->treatments_id = $treatments->id;
                    $q_detail->procedure_id = $values[0];
                    $q_detail->price = $values[1];
                    $q_detail->save();
                    $item++;
                }

                Session::push('success', 'Saved data.');
                DB::commit();
                return '/treatments';
            }catch (Exception $e){
                Session::push('error','Transaction error.');
                DB::rollback();
                return '/treatments-edit/'. $id;
            }
        });

        return redirect($return);
    }

    /**
     * Delete an item
     * @param $id
     * @return redirect to de list of the object
     */
    public function delete($id){
        if(Procedures::where('id','=', $id)->first() === null){
            Session::push('error','Element not found.');
        }else{

            $return =DB::transaction(function () use ($id){
                try {

                    $detail = Treatments_Detail::where(['treatments_id', '=', $id], ['status', '=', 0])->get();

                    if($detail){
                        Session::push('error','Treatment is in progress, cannot be removed.');
                        DB::rollback();
                        return '/treatments-edit/'. $id;
                    }else{
                        Treatments_Detail::where('treatments_id', '=', $id)->delete();
                        Treatments::where('id', '=', $id)->delete();
                        Session::push('success','Deleted data.');
                        DB::commit();
                        return '/treatments';
                    }
                }catch (Exception $e){
                    Session::push('error','Transaction error.');
                    DB::rollback();
                    return '/treatments-edit/'. $id;
                }
            });
            return redirect($return);
        }
    }

     /**
     * Autocomplete the patient search for appointments
     * @return \Illuminate\Http\Response
     */
    public function searchTreatment(Request $request){
        try {

            $data = Patients::where('completeName', 'LIKE', "%{$request->input('query')}%")
            ->join('treatments', 'patients.id', '=', 'treatments.patients_id')
            ->where('treatments.status', '<>', '1')
            ->groupBy('patients.id', 'patients.completeName')
            ->select('patients.id', 'patients.completeName')->get();

            return response()->json($data);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }

    /**
     * Autocomplete the patient search for appointments
     * @return \Illuminate\Http\Response
     */
    public function viewTreatmentDetail(Request $request){
        try {

            $det = DB::table('treatments_detail')
            ->join('procedures', 'treatments_detail.procedure_id', '=', 'procedures.id')
            ->where('treatments_detail.treatments_id','=',$request->input('query'))
            ->select('procedures.id', 'procedures.name', 'treatments_detail.status')->get();

            return new JsonResponse($det);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }

    /**
     * Autocomplete the patient search for appointments
     * @return \Illuminate\Http\Response
     */
    public function searchTreatmentDetail(Request $request){
        try {

            $det = DB::table('treatments_detail')
            ->join('treatments', 'treatments_detail.treatments_id', 'treatments.id')
            ->join('procedures', 'treatments_detail.procedure_id', '=', 'procedures.id')
            ->where([['treatments.patients_id','=',$request->input('query')], ['treatments_detail.status', '<>', '1']])
            ->select('procedures.id', 'procedures.name', 'treatments_detail.treatments_id')->get();

            return new JsonResponse($det);
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
            ['name'=>'required|min:5|max:50', 'total'=>'required|numeric|min:0.01']);

        if($validator->fails()){
            Session::push('error','message');
            return redirect($redirect)->withInput()->withErrors($validator);
        }
    }
}
