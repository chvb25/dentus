<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Question;
use App\Question_Type;
use App\Answer;
use function foo\func;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
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
        return view('quiz.question-edit', ['qs' => $qs, 'qt' => Question_Type::orderBy('id', 'asc')->get(), 'answers' => Answer::orderBy('id', 'asc')->where('question_id', "=", $id )->get()]);
    }

    /**
     * Register an item
     * @param Request $request
     * @return reditect to de list of the object
     */
    public function save(Request $request){
        $this->validateData($request, '/question/new');

        $return = DB::transaction(function () use ($request){
            try{
                $qt = new Question();
                $qt->question = $request->question;
                $qt->question_type_id = $request->question_type;
                $qt->test_id = 1;
                $qt->save();

                foreach ($request->dynamic as $item) {
                    if (count($request->dynamic) == 1 && $item == "") break;
                    $answer = new Answer();
                    $answer->question_id = $qt->id;
                    $answer->answer = $item;
                    $answer->save();
                }

                Session::push('success','Saved data.');
                return '/questions';
            }catch (\Exception $e){
                Session::push('error','Transaction error.');
                return '/question/new';
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
        if(Question::where('id','=', $id)->first() === null){
            Session::push('error','Element not found.');
        }else{
            $this->validateData($request, '/question-edit/'. $id);

            $return =DB::transaction(function () use ($request, $id){
                try {
                    $qt = Question::findOrFail($id);
                    $qt->question = $request->question;
                    $qt->question_type_id = $request->question_type;
                    $qt->test_id = 1;
                    $qt->save();

                    Answer::where('question_id', '=', $id)->delete();
                    foreach ($request->dynamic as $item) {
                        if (count($request->dynamic) == 1 && $item == "") break;
                        $answer = new Answer();
                        $answer->question_id = $id;
                        $answer->answer = $item;

                        $answer->save();
                    }
                    Session::push('success','Updated data.');
                    return '/questions';
                }catch (Exception $e){
                    Session::push('error','Transaction error.');
                    return '/question-edit/'. $id;
                }
            });
        }
        return redirect($return);
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
            Answer::where('question_id', "=", $id)->delete();
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
