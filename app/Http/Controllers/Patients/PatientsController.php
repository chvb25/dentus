<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Country;
use App\Patients;
use App\Procedures;
use App\Test;
use App\Test_Result;
use App\Odontogram;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use Validator;
use Illuminate\Http\Request;
use DateTime;

class PatientsController extends Controller
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
        return view('patients.patients', ['data' => Patients::orderBy('id', 'asc')->get()]);
    }

    public function toRegister(){
        return view('patients.patients-new', ['nat' => Country::orderBy('name', 'asc')->get(),
        'procedures'=> Procedures::orderBy('id', 'asc')->get(),
        'test'=> Test::first()]);

    }

    public  function toUpdate($id){
        $patients = Patients::findOrFail($id);
        return view('patients.patients-edit', ['pts' => $patients,
        'nat' => Country::orderBy('name', 'asc')->get(),
        'procedures'=> Procedures::orderBy('id', 'asc')->get(),
        'test'=> Test::first(),
        'result'=> Test_Result::where('patient_id', $id)->get()]);
    }

    /**
     * Register an item
     * @param Request $request
     * @return redirect to de list of the object
     */
    public function save(Request $request){
        $this->validateData($request, '/patients/new');
        $return = DB::transaction(function () use ($request){
            try{
                $date = DateTime::createFromFormat('d/m/Y', $request->birthDate);
                $usableDate = $date->format('Y-m-d');

                $pts = new Patients();
                $pts->name = $request->name;
                $pts->lastName = $request->lastName;
                $pts->completeName = $request->name. " ". $request->lastName;
                $pts->dni = $request->dni;
                $pts->phone = $request->phone;
                $pts->birthDate = $usableDate;
                $pts->civilState = $request->civilState;
                $pts->nationality= $request->nationality;
                $pts->address = $request->address;
                $pts->profession = $request->profession;
                $pts->jobAddress = $request->jobAddress;
                $pts->jobTitle = $request->jobTitle;
                $pts->save();

                $teeth = explode(",", $request->tooth);
                foreach ($teeth as  $value) {
                    $data = explode("|", $value);
                    $odontogram = new Odontogram();
                    $odontogram->patients_id = $pts->id;
                    $odontogram->procedure_id = $data[1];
                    $odontogram->tooth = $data[0];
                    $odontogram->save();
                }

                $test = Test::first();
                foreach ($test->questions as $question) {
                    if($request->has('qt'. $question->id)){
                        if (is_array($request->get('qt'. $question->id))) {
                            foreach ($request->get('qt'. $question->id) as $answer) {
                                $test_result = new Test_Result();
                                $test_result->patient_id = $pts->id;
                                $test_result->test_id = 1;
                                $test_result->question_id = $question->id;
                                $test_result->answer = $answer;
                                $test_result->save();
                            }
                        }else{
                            $test_result = new Test_Result();
                            $test_result->patient_id = $pts->id;
                            $test_result->test_id = 1;
                            $test_result->question_id = $question->id;
                            $test_result->answer = $request->get('qt'. $question->id);
                            $test_result->save();
                        }
                    }
                }

                Session::push('success', 'Se ha realizado el registro correctamente.');
                DB::commit();
                return '/patients';
            }catch (\Exception $e){
                DB::rollback();
                error_log('Error en la transaccion : '. $e->getMessage());
                Session::push('error','No se ha completado la transacción.');
                return 'patients/new';
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
        if(Patients::where('id','=', $id)->first() === null){
            Session::push('error','No se ha encontrado el registro.');
        }else{
            $this->validateData($request, '//patients-edit/'. $id);
            $return = DB::transaction(function () use ($request, $id){
                try{
                    $date = DateTime::createFromFormat('d/m/Y', $request->birthDate);
                    $usableDate = $date->format('Y-m-d');

                    $pts = Patients::findOrFail($id);
                    $pts->name = $request->name;
                    $pts->lastName = $request->lastName;
                    $pts->completeName = $request->name. " ". $request->lastName;
                    $pts->dni = $request->dni;
                    $pts->phone = $request->phone;
                    $pts->birthDate = $usableDate;
                    $pts->civilState = $request->civilState;
                    $pts->nationality= $request->nationality;
                    $pts->address = $request->address;
                    $pts->profession = $request->profession;
                    $pts->jobAddress = $request->jobAddress;
                    $pts->jobTitle = $request->jobTitle;
                    $pts->save();

                    Odontogram::where('patients_id', $pts->id)->delete();
                    $teeth = explode(",", $request->tooth);
                    foreach ($teeth as  $value) {
                        $data = explode("|", $value);
                        $odontogram = new Odontogram();
                        $odontogram->patients_id = $pts->id;
                        $odontogram->procedure_id = $data[1];
                        $odontogram->tooth = $data[0];
                        $odontogram->save();
                    }

                    $test = Test::first();
                    Test_Result::where('patient_id', $pts->id)->where('test_id', $test->id )->delete();
                    foreach ($test->questions as $question) {
                        if($request->has('qt'. $question->id)){
                            if (is_array($request->get('qt'. $question->id))) {
                                foreach ($request->get('qt'. $question->id) as $answer) {
                                    $test_result = new Test_Result();
                                    $test_result->patient_id = $pts->id;
                                    $test_result->test_id = $test->id;
                                    $test_result->question_id = $question->id;
                                    $test_result->answer = $answer;
                                    $test_result->save();
                                }
                            }else{
                                $test_result = new Test_Result();
                                $test_result->patient_id = $pts->id;
                                $test_result->test_id = $test->id;
                                $test_result->question_id = $question->id;
                                $test_result->answer = ($request->get('qt'. $question->id) == "") ? " " :$request->get('qt'. $question->id);
                                $test_result->save();
                            }
                        }
                    }

                    Session::push('success', 'Se ha realizado el registro correctamente.');
                    DB::commit();
                    return '/patients';
                }catch (\Exception $e){
                    DB::rollback();
                    error_log('Error en la transaccion : '. $e->getMessage());
                    Session::push('error','No se ha completado la transacción.');
                    return 'patients-edit/'. $id;
                }
            });
            return redirect($return);
        }
    }

    /**
     * Delete an item
     * @param $id
     * @return redirect to de list of the object
     */
    public function delete($id){
        if(Patients::where('id','=', $id)->first() === null){
            Session::push('error','No se ha encontrado el registro.');
        }else{
            DB::transaction(function () use ($id){
                try{
                    $test = Test::first();
                    Patients::findOrFail($id)->delete();
                    Odontogram::where('patients_id', $id)->delete();
                    Test_Result::where('patient_id', $id)->where('test_id', $test->id )->delete();
                    Session::push('success', 'Se ha eliminado el registro correctamente.');
                    DB::commit();
                }catch (\Exception $e){
                    DB::rollback();
                    error_log('Error en la transaccion : '. $e->getMessage());
                    Session::push('error','No se ha completado la transacción.');
                }
            });
        }
        return redirect('/patients');
    }

      /**
     * Autocomplete the patient search
     * @return \Illuminate\Http\Response
     */
    public function searchPatient(Request $request){
        try {
            $data = Patients::where('completeName', 'LIKE', "%{$request->input('query')}%")->select('id', 'completeName')->get();
            return response()->json($data);
        } catch (\Throwable $th) {
            error_log($th->message);
        }

    }

    /**
     * Validate the options at the page
     * @param Request $request
     * @param array $redirect
     * @return mixed the addres to be redirected with errors
     */
    private function validateData(Request $request, $redirect){
        $validator = Validator::make($request->all(),
            ['name'=>'required|min:5|max:190', 'lastName'=>'required|min:5|max:190', 'dni'=>'required|min:5']);

        if($validator->fails()){
            Session::push('error','message');
            return redirect($redirect)->withInput()->withErrors($validator);
        }
    }

}
