<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Question;
use App\Question_Type;
use Illuminate\Support\Facades\Session;
use Validator;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(){
        return view('quiz.question', ['data' => Question::orderBy('id', 'asc')->get()]);
    }

    public function toRegister(){
        return view('quiz.question-new', ['qt' => Question_Type::orderBy('id', 'asc')->get()]);
    }

    public  function toUpdate($id){
        $qs = Question::findOrFail($id);
        return view('quiz.question-edit', ['qs' => $qs, 'qt' => Question_Type::orderBy('id', 'asc')->get()]);
    }

    /**
     * Register an item
     * @param Request $request
     * @return reditect to de list of the object
     */
    public function save(Request $request){
        $this->validateData($request, '/question/new');

        $qt = new Question();
        $qt->question = $request->question;
        $qt->question_type_id = $request->question_type;
        $qt->test_id = 1;
        $qt->save();

        Session::push('success','Saved data.');
        return redirect('/questions');
    }

    /**
     * Update an item
     * @param Request $request
     * @param $id
     * @return reditect to de list of the object
     */
    public function update(Request $request, $id){
        if(Question::where('id','=', $id)->first() === null){
            Session::push('error','Element not found.');
        }else{
            $this->validateData($request, '/question-edit/'. $id);

            $qt = Question::findOrFail($id);
            $qt->question = $request->question;
            $qt->question_type_id = $request->question_type;
            $qt->test_id = 1;
            $qt->save();
        }
        Session::push('success','Updated data.');
        return redirect('/questions');
    }

    /**
     * Delete an item
     * @param $id
     * @return reditect to de list of the object
     */
    public function delete($id){
        if(Question::where('id','=', $id)->first() === null){
            Session::push('error','Element not found.');
        }else{
            Question::findOrFail($id)->delete();
            Session::push('success','Deleted data.');
        }
        return redirect('/questions');
    }

    /**
     * Validate the options at the page
     * @param Request $request
     * @param array $redirect
     * @return mixed the addres to be redirected with errors
     */
    private function validateData(Request $request, $redirect){
        $validator = Validator::make($request->all(),
            ['question'=>'required|min:5|max:100',
                'question_type'=>'required|not_in:0']);

        if($validator->fails()){
            Session::push('error','message');
            return redirect($redirect)->withInput()->withErrors($validator);
        }
    }
}
