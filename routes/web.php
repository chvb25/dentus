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

Route::get('questions/{test_id}', 'Quiz\QuestionController@index');

Route::get('question/new/{test_id}', 'Quiz\QuestionController@toRegister');

Route::get('question-edit/{id}/{test_id}', 'Quiz\QuestionController@toUpdate');

Route::post('/save-q', 'Quiz\QuestionController@save');

Route::put('/update-q/{id}/{test_id}', 'Quiz\QuestionController@update');

Route::delete('question/delete/{id}/{test_id}', 'Quiz\QuestionController@delete');

/*
|--------------------------------------------------------------------------
| Answers Section
|--------------------------------------------------------------------------
*/
Route::get('answers', 'Quiz\AnswerController@index');

Route::get('answer/new', 'Quiz\AnswerController@toRegister');

Route::get('answer-edit/{id}', 'Quiz\AnswerController@toUpdate');

Route::post('/save-answer', 'Quiz\AnswerController@save');

Route::put('/update-answer/{id}', 'Quiz\AnswerController@update');

Route::delete('answer/delete/{id}', 'Quiz\AnswerController@delete');

/*
|--------------------------------------------------------------------------
| Quiz Section
|--------------------------------------------------------------------------
*/
Route::get('test', 'Quiz\TestController@index');

Route::get('test/new', 'Quiz\TestController@toRegister');

Route::get('test-edit/{id}', 'Quiz\TestController@toUpdate');

Route::post('/save-test', 'Quiz\TestController@save');

Route::put('/update-test/{id}', 'Quiz\TestController@update');

Route::delete('test/delete/{id}', 'Quiz\TestController@delete');

/*
|--------------------------------------------------------------------------
| Patients
|--------------------------------------------------------------------------
*/
Route::get('patients', 'Patients\PatientsController@index');

Route::get('patients/new', 'Patients\PatientsController@toRegister');

Route::get('patients-edit/{id}', 'Patients\PatientsController@toUpdate');

Route::post('/save-patients', 'Patients\PatientsController@save');

Route::put('/update-patients/{id}', 'Patients\PatientsController@update');

Route::delete('patients/delete/{id}', 'Patients\PatientsController@delete');

Route::get('patients/autocomplete', 'Patients\PatientsController@searchPatient')->name('patientList');

/*
|--------------------------------------------------------------------------
| Procedures
|--------------------------------------------------------------------------
*/
Route::get('procedures', 'Procedure\ProceduresController@index');

Route::get('procedures/new', 'Procedure\ProceduresController@toRegister');

Route::get('procedures-edit/{id}', 'Procedure\ProceduresController@toUpdate');

Route::post('/save-procedures', 'Procedure\ProceduresController@save');

Route::put('/update-procedures/{id}', 'Procedure\ProceduresController@update');

Route::delete('procedures/delete/{id}', 'Procedure\ProceduresController@delete');

/*
|--------------------------------------------------------------------------
| Treatments
|--------------------------------------------------------------------------
*/
Route::get('treatments', 'Procedure\TreatmentsController@index');

Route::get('treatments/new', 'Procedure\TreatmentsController@toRegister');

Route::get('treatments-edit/{id}', 'Procedure\TreatmentsController@toUpdate');

Route::post('/save-treatments', 'Procedure\TreatmentsController@save');

Route::put('/update-treatments/{id}', 'Procedure\TreatmentsController@update');

Route::delete('treatments/delete/{id}', 'Procedure\TreatmentsController@delete');

Route::get('treatments/searchTreatment', 'Procedure\TreatmentsController@searchTreatment')->name('treatmentList');

Route::get('treatments/searchTreatmentDetail', 'Procedure\TreatmentsController@searchTreatmentDetail')->name('treatmentDetails');

Route::get('treatments/viewTreatmentDetail', 'Procedure\TreatmentsController@viewTreatmentDetail')->name('viewDetails');

/*
|--------------------------------------------------------------------------
| Quotes
|--------------------------------------------------------------------------
*/
Route::get('quotes', 'Procedure\QuoteController@index');

Route::get('quotes/new', 'Procedure\QuoteController@toRegister');

Route::get('quotes-edit/{id}', 'Procedure\QuoteController@toUpdate');

Route::post('/save-quotes', 'Procedure\QuoteController@save');

Route::put('/update-quotes/{id}', 'Procedure\QuoteController@update');

Route::delete('quotes/delete/{id}', 'Procedure\QuoteController@delete');

Route::get('quotes/searchQuoteDetail', 'Procedure\QuoteController@searchQuoteDetail')->name('quoteDetails');

/*
|--------------------------------------------------------------------------
| Appointments
|--------------------------------------------------------------------------
*/
Route::get('appointments', 'Appointments\AppointmentsController@index');

Route::get('appointments/byDate/', 'Appointments\AppointmentsController@listByDate')->name('appointmentsByDate');

Route::get('appointments/new', 'Appointments\AppointmentsController@toRegister');

Route::get('appointments-edit/{id}', 'Appointments\AppointmentsController@toUpdate');

Route::post('/save-appointments', 'Appointments\AppointmentsController@save');

Route::post('/save-appointments_t', 'Appointments\AppointmentsController@saveWithTreatment');

Route::put('/update-appointments/{id}', 'Appointments\AppointmentsController@update');

Route::put('/update-appointments_t/{id}', 'Appointments\AppointmentsController@updateWithTreatment');

Route::put('/reschedule-appointments/{id}', 'Appointments\AppointmentsController@reschedule');

Route::put('/cancel-appointments/{id}', 'Appointments\AppointmentsController@cancel');

Route::delete('appointments/delete/{id}', 'Appointments\AppointmentsController@delete');
/*
|--------------------------------------------------------------------------
| Attention
|--------------------------------------------------------------------------
*/
Route::get('attention/new/{id}', 'Appointments\AttentionController@toRegister');

Route::post('/save-attention/{id}', 'Appointments\AttentionController@save');