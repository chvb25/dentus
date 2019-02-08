<?php

namespace App\Http\Controllers\Procedure;

use App\Http\Controllers\Controller;
use App\Procedures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;


class ProceduresController extends Controller
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
        return view('procedures.procedures', ['data' => Procedures::orderBy('id', 'asc')->get()]);
    }

    public function toRegister(){
        return view('procedures.procedures-new');
    }

    public  function toUpdate($id){
        $procedure = Procedures::findOrFail($id);
        return view('procedures.procedures-edit', ['procedure' => $procedure]);
    }

    /**
     * Register an item
     * @param Request $request
     * @return redirect to de list of the object
     */
    public function save(Request $request){
        $this->validateData($request, '/procedures/new');

        $procedures = new Procedures();
        $procedures->name = $request->name;
        $procedures->cost = $request->cost;
        $procedures->type = $request->types;
        $procedures->color = $request->color;
        $procedures->save();

        Session::push('success', 'Se ha realizado el registro correctamente.');
        return redirect('/procedures');
    }

    /**
     * Update an item
     * @param Request $request
     * @param $id
     * @return redirect to de list of the object
     */
    public function update(Request $request, $id){
        if(Procedures::where('id','=', $id)->first() === null){
            Session::push('error','No se ha encontrado el registro.');
        }else{
            $this->validateData($request, '//procedures-edit/'. $id);

            $procedures = Procedures::findOrFail($id);
            $procedures->name = $request->name;
            $procedures->cost = $request->cost;
            $procedures->type = $request->types;
            $procedures->color = $request->color;
            $procedures->save();

        }
        Session::push('success', 'Se ha actualizado el registro correctamente.');
        return redirect('/procedures');
    }

    /**
     * Delete an item
     * @param $id
     * @return redirect to de list of the object
     */
    public function delete($id){
        if(Procedures::where('id','=', $id)->first() === null){
            Session::push('error','No se ha encontrado el registro.');
        }else{
            Procedures::findOrFail($id)->delete();
            Session::push('success', 'Se ha eliminado el registro correctamente.');
        }
        return redirect('/procedures');
    }

    /**
     * Validate the options at the page
     * @param Request $request
     * @param array $redirect
     * @return mixed the path to be redirected with errors
     */
    private function validateData(Request $request, $redirect){
        $validator = Validator::make($request->all(),
            ['name'=>'required|min:5|max:50']);

        if($validator->fails()){
            Session::push('error','message');
            return redirect($redirect)->withInput()->withErrors($validator);
        }
    }
}
