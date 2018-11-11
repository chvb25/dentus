<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Question Type Section
|--------------------------------------------------------------------------
*/
Route::get('question-type', 'Quiz\QuestionTypeController@index');

Route::get('question-type/new', 'Quiz\QuestionTypeController@toRegister');

Route::get('question-type-edit/{id}', 'Quiz\QuestionTypeController@toUpdate');

Route::post('/save-qt', 'Quiz\QuestionTypeController@save');

Route::put('/update-qt/{id}', 'Quiz\QuestionTypeController@update');

Route::delete('question-type/delete/{id}', 'Quiz\QuestionTypeController@delete');

/*
|--------------------------------------------------------------------------
| Question Section
|--------------------------------------------------------------------------
*/

Route::get('questions', 'Quiz\QuestionController@index');

Route::get('question/new', 'Quiz\QuestionController@toRegister');

Route::get('question-edit/{id}', 'Quiz\QuestionController@toUpdate');

Route::post('/save-q', 'Quiz\QuestionController@save');

Route::put('/update-q/{id}', 'Quiz\QuestionController@update');

Route::delete('question/delete/{id}', 'Quiz\QuestionController@delete');


Route::get('user/{id}', function ($id) {
    return 'User '.$id;
});