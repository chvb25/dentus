<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Test;
use App\Question;
use function foo\func;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use Validator;
use Illuminate\Http\Request;

class TestController extends Controller
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
        return view('quiz.test', ['data' => Test::orderBy('id', 'asc')->get()]);
    }

    public function toRegister(){
        return view('quiz.test-new');
    }

    public  function toUpdate($id){
        $test = Test::findOrFail($id);
        return view('quiz.test-edit', ['test' => $test]);
    }

    public function quiz(){
        return view('quiz.quiz', ['test'=> Test::first()]);
    }

    /**
     * Register an item
     * @param Request $request
     * @return redirect to de list of the object
     */
    public function save(Request $request){
        $this->validateData($request, '/test/new');

        $qt = new Test();
        $qt->title = $request->title;
        $qt->description = $request->description === null ? '':$request->description ;
        $qt->save();

        Session::push('success', 'Se ha realizado el registro correctamente.');
        if ($request->nqt)
            return redirect('//questions/'. $qt->id);
        else
            return redirect('/test');
    }

    /**
     * Update an item
     * @param Request $request
     * @param $id
     * @return redirect to de list of the object
     */
    public function update(Request $request, $id){
        if(Test::where('id','=', $id)->first() === null){
            Session::push('error','No se ha encontrado el registro.');
        }else{
            $this->validateData($request, '/test-eidt/'. $id);

            $qt = Test::findOrFail($id);
            $qt->title = $request->title;
            $qt->description = $request->description;
            $qt->save();
        }
        Session::push('success', 'Se ha actualizado el registro correctamente.');
        return redirect('/test');
    }

    /**
     * Delete an item
     * @param $id
     * @return redirect to de list of the object
     */
    public function delete($id){
        if(Test::where('id','=', $id)->first() === null){
            Session::push('error','No se ha encontrado el registro.');
        }else{
            Test::findOrFail($id)->delete();
            Session::push('success', 'Se ha eliminado el registro correctamente.');
        }
        return redirect('/test');
    }

    /**
     * Validate the options at the page
     * @param Request $request
     * @param array $redirect
     * @return mixed the addres to be redirected with errors
     */
    private function validateData(Request $request, $redirect){
        $validator = Validator::make($request->all(),
            ['title'=>'required|min:5|max:50', 'description'=>'max:190']);

        if($validator->fails()){
            Session::push('error','message');
            return redirect($redirect)->withInput()->withErrors($validator);
        }
    }
}
