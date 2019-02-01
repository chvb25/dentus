<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Country;
use App\Patients;
use function foo\func;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use Validator;
use Illuminate\Http\Request;
use DateTime;

class PatientsController extends Controller
{
    public function index(){
        return view('patients.patients', ['data' => Patients::orderBy('id', 'asc')->get()]);
    }

    public function toRegister(){
        return view('patients.patients-new', ['nat' => Country::orderBy('name', 'asc')->get()] );

    }

    public  function toUpdate($id){
        $patients = Patients::findOrFail($id);
        return view('patients.patients-edit', ['pts' => $patients, 'nat' => Country::orderBy('name', 'asc')->get()]);
    }

    /**
     * Register an item
     * @param Request $request
     * @return redirect to de list of the object
     */
    public function save(Request $request){
        $this->validateData($request, '/patients/new');

        $date = DateTime::createFromFormat('d/m/Y', $request->birthDate);        
        $usableDate = $date->format('Y-m-d');

        $pts = new Patients();
        $pts->name = $request->name;
        $pts->lastName = $request->lastName;
        $pts->completeName = $request->name. " ". $request->lastName;
        $pts->dni = $request->dni;
        $pts->birthDate = $usableDate;
        $pts->civilState = $request->civilState;
        $pts->nationality= $request->nationality;
        $pts->address = $request->address;
        $pts->profession = $request->profession;
        $pts->jobAddress = $request->jobAddress;
        $pts->jobTitle = $request->jobTitle;
        $pts->save();

        Session::push('success','Saved data.');
        if ($request->nqt)
            return redirect('/patients/'. $pts->id);
        else
            return redirect('/patients');
    }

    /**
     * Update an item
     * @param Request $request
     * @param $id
     * @return redirect to de list of the object
     */
    public function update(Request $request, $id){
        if(Patients::where('id','=', $id)->first() === null){
            Session::push('error','Element not found.');
        }else{
            $this->validateData($request, '/patients-edit/'. $id);

            $date = DateTime::createFromFormat('d/m/Y', $request->birthDate);        
        $usableDate = $date->format('Y-m-d');

            $pts = Patients::findOrFail($id);
            $pts->name = $request->name;
            $pts->lastName = $request->lastName;
            $pts->completeName = $request->name. " ". $request->lastName;
            $pts->dni = $request->dni;
            $pts->birthDate = $usableDate;
            $pts->civilState = $request->civilState;
            $pts->nationality= $request->nationality;
            $pts->address = $request->address;
            $pts->profession = $request->profession;
            $pts->jobAddress = $request->jobAddress;
            $pts->jobTitle = $request->jobTitle;
            $pts->save();
        }
        Session::push('success','Updated data.');
        return redirect('/patients');
    }

    /**
     * Delete an item
     * @param $id
     * @return redirect to de list of the object
     */
    public function delete($id){
        if(Patients::where('id','=', $id)->first() === null){
            Session::push('error','Element not found.');
        }else{
            Patients::findOrFail($id)->delete();
            Session::push('success','Deleted data.');
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
