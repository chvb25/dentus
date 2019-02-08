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
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/main', 'HomeController@main')->name('main');

/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
*/
Route::get('/register-user', 'Auth\RegisterController@register')->name('register');

Route::put('password/reset', 'Auth\ResetPasswordController@reset' );

Route::get('users', 'Settings\UserController@index');

Route::get('user/new', 'Settings\UserController@toRegister');

Route::get('user-edit/{id}', 'Settings\UserController@toUpdate');

Route::get('user-view', 'Settings\UserController@viewProfile');

Route::put('/save-user', 'Settings\UserController@save');

Route::put('update-user/{id}', 'Settings\UserController@update');

Route::delete('user/delete/{id}', 'Settings\UserController@delete');



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
*//*
Route::get('answers', 'Quiz\AnswerController@index');

Route::get('answer/new', 'Quiz\AnswerController@toRegister');

Route::get('answer-edit/{id}', 'Quiz\AnswerController@toUpdate');

Route::post('/save-answer', 'Quiz\AnswerController@save');

Route::put('/update-answer/{id}', 'Quiz\AnswerController@update');

Route::delete('answer/delete/{id}', 'Quiz\AnswerController@delete');
*/
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

Route::get('quiz', 'Quiz\TestController@quiz');

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

Route::get('odontogram/getTeeth', 'Patients\OdontogramController@getTeeth')->name('teeth');

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

/*
|--------------------------------------------------------------------------
| Cash
|--------------------------------------------------------------------------
*/
Route::get('cash', 'Cashier\CashController@index');

Route::get('cash/new/{attention_id}/{receivable_id}', 'Cashier\CashController@toRegister');

Route::post('/save-cash/{id}/{receivable_id}', 'Cashier\CashController@save');

/*
|--------------------------------------------------------------------------
| Receivable
|--------------------------------------------------------------------------
*/
Route::get('receivable/new/{attention_id}', 'Cashier\ReceivableController@toRegister');

Route::post('/save-receivable/{attention_id}', 'Cashier\ReceivableController@save');
/*
|--------------------------------------------------------------------------
| Payment Plan
|--------------------------------------------------------------------------
*/
Route::get('payment_plan', 'Cashier\Payment_PlanController@index');
/*
|--------------------------------------------------------------------------
| Setting
|--------------------------------------------------------------------------
*/
Route::get('setting', 'Settings\SettingController@index');

Route::put('save-setting', 'Settings\SettingController@save');
