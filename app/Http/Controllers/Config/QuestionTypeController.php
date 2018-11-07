<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Question_Type;
use Illuminate\Http\Request;


class QuestionTypeController extends Controller
{
    public function index(){
        return view('config.question-type', ['data' => Question_Type::orderBy('id', 'asc')->get()]);
    }

}
