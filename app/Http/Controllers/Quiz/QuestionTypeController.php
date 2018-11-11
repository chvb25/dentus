<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Question_Type;
use Illuminate\Support\Facades\Session;
use Validator;
use Illuminate\Http\Request;


class QuestionTypeController extends Controller
{
    public function index(){
        return view('quiz.question-type', ['data' => Question_Type::orderBy('id', 'asc')->get()]);
    }

    public function toRegister(){
        return view('quiz.question-type-new');
    }

    public  function toUpdate($id){
        $qt = Question_Type::findOrFail($id);
        return view('quiz.question-type-edit', ['qt' => $qt]);
    }

    /**
     * Register an item
     * @param Request $request
     * @return reditect to de list of the object
     */
    public function save(Request $request){
        $this->validateData($request, '/question-type/new');

        $qt = new Question_Type();
        $qt->name = $request->name;
        $qt->language = $request->language;
        $qt->save();

        Session::push('success','Saved data.');
        return redirect('/question-type');
    }

    /**
     * Update an item
     * @param Request $request
     * @param $id
     * @return reditect to de list of the object
     */
    public function update(Request $request, $id){
        if(Question_Type::where('id','=', $id)->first() === null){
            Session::push('error','Element not found.');
        }else{
            $this->validateData($request, '/question-type-eidt/'. $id);

            $qt = Question_Type::findOrFail($id);
            $qt->name = $request->name;
            $qt->language = $request->language;
            $qt->save();
        }
        Session::push('success','Updated data.');
        return redirect('/question-type');
    }

    /**
     * Delete an item
     * @param $id
     * @return reditect to de list of the object
     */
    public function delete($id){
        if(Question_Type::where('id','=', $id)->first() === null){
            Session::push('error','Element not found.');
        }else{
            Question_Type::findOrFail($id)->delete();
            Session::push('success','Deleted data.');
        }
        return redirect('/question-type');
    }

    /**
     * Validate the options at the page
     * @param Request $request
     * @param array $redirect
     * @return mixed the addres to be redirected with errors
     */
    private function validateData(Request $request, $redirect){
        $validator = Validator::make($request->all(),
            ['name'=>'required|min:5|max:50',
             'language'=>'required|not_in:0']);

        if($validator->fails()){
            Session::push('error','message');
            return redirect($redirect)->withInput()->withErrors($validator);
        }
    }

}
