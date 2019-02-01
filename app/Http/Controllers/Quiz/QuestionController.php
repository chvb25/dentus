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
    public function index($test_id){
        return view('quiz.question', ['data' => Question::orderBy('id', 'asc')->where('test_id','=', $test_id)->get(), 'test_id'=>$test_id]);
    }

    public function toRegister($test_id){
        return view('quiz.question-new', ['qt' => Question_Type::orderBy('id', 'asc')->get(), 'test_id'=>$test_id]);
    }

    public  function toUpdate($id, $test_id){
        $qs = Question::findOrFail($id);
        return view('quiz.question-edit', ['qs' => $qs, 'qt' => Question_Type::orderBy('id', 'asc')->get(), 'answers' => Answer::orderBy('id', 'asc')->where('question_id', "=", $id )->get(), 'test_id'=>$test_id]);
    }

    /**
     * Register an item
     * @param Request $request
     * @return redirect to de list of the object
     */
    public function save(Request $request){
        $this->validateData($request, '/question/new/'. $request->test_id);

        $return = DB::transaction(function () use ($request){
            try{
                $qt = new Question();
                $qt->question = $request->question;
                $qt->question_type_id = $request->question_type;
                $qt->test_id = $request->test_id;
                $qt->save();

                foreach ($request->dynamic as $item) {
                    if (count($request->dynamic) == 1 && $item == "") break;
                    $answer = new Answer();
                    $answer->question_id = $qt->id;
                    $answer->answer = $item;
                    $answer->save();
                }

                Session::push('success','Saved data.');
                DB::commit();
                return '/questions/'. $request->input('test_id');
            }catch (\Exception $e){
                Session::push('error','Transaction error.');
                DB::rollback();
                return '/question/new/'. $request->test_id;
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
        if(Question::where('id','=', $id)->first() === null){
            Session::push('error','Element not found.');
        }else{
            $this->validateData($request, '/question-edit/'. $id.'/'. $request->input('test_id'));

            $return =DB::transaction(function () use ($request, $id){
                try {
                    $qt = Question::findOrFail($id);
                    $qt->question = $request->question;
                    $qt->question_type_id = $request->question_type;
                    $qt->test_id = $request->test_id;
                    $qt->save();

                    Answer::where('question_id', '=', $id)->delete();
                    if ($request->dynamic !== null)
                        foreach ($request->dynamic as $item) {
                            if (count($request->dynamic) == 1 && $item == "") break;
                            $answer = new Answer();
                            $answer->question_id = $id;
                            $answer->answer = $item;

                            $answer->save();
                        }
                    Session::push('success','Updated data.');
                    DB::commit();
                    return '/questions/'. $request->test_id;
                }catch (Exception $e){
                    Session::push('error','Transaction error.');
                    DB::rollback();
                    return '/question-edit/'. $id;
                }
            });
        }
        return redirect($return);
    }

    /**
     * Delete an item
     * @param $id
     * @return redirect to de list of the object
     */
    public function delete($id, $test_id){
        if(Question::where('id','=', $id)->first() === null){
            Session::push('error','Element not found.');
        }else{
            Question::findOrFail($id)->delete();
            Answer::where('question_id', "=", $id)->delete();
            Session::push('success','Deleted data.');
        }
        return redirect('/questions/'. $test_id);
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
