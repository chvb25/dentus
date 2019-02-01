<?php

namespace App\Http\Controllers\Procedure;

use App\Http\Controllers\Controller;
use App\Quote;
use App\Quote_Detail;
use App\Procedures;
use App\Patients;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;
use DateTime;

class QuoteController extends Controller
{
    public function index(){
        return view('procedures.quotes', ['data' => Quote::where('status', '=', '1')->orderBy('id', 'asc')->get()]);
    }

    public function toRegister(){
        return view('procedures.quotes-new', ['procedures' => Procedures::where('type','=','P')->get()]);
    }

    public  function toUpdate($id){
        $quote = Quote::findOrFail($id);
        $procedures_id = Quote_Detail::where('quote_id', '=', $id)->select('procedure_id')->get();
        return view('procedures.quotes-edit', ['quote' => $quote,
            'procedures' => DB::table('procedures')->where('type', '=', 'P')->whereNotIn('id', $procedures_id)->get(),
            'detail'=> DB::table('quote_detail')->join('procedures', 'quote_detail.procedure_id', '=', 'procedures.id')->where('quote_id','=',$id)->select('procedures.*')->get()]);
    }

    /**
     * Register an item
     * @param Request $request
     * @return redirect to de list of the object
     */
    public function save(Request $request){
        $this->validateData($request, '/quotes/new');

        $return = DB::transaction(function () use ($request){            
            try {
                $date = DateTime::createFromFormat('d/m/Y', $request->date);        
                $usableDate = $date->format('Y-m-d');
                
                $quote = new Quote();
                $quote->patient_id = $request->patient_id;
                $quote->date = $usableDate;                
                $quote->sub_total = $request->subtotal;
                $quote->discount = $request->discount;
                $quote->final_price = $request->total;                
                $quote->status = true;
                $quote->save();
                
                $item = 1;
                foreach ($request->dynamic as $items) {
                    if (count($request->dynamic) == 1 && $items == "") break;
                    $values = \explode('-', $items);                    
                    $q_detail = new Quote_Detail();
                    $q_detail->id = $item;
                    $q_detail->quote_id = $quote->id;
                    $q_detail->procedure_id = $values[0];
                    $q_detail->price = $values[1];
                    $q_detail->save();
                    $item++;
                }

                Session::push('success', 'Saved data.');
                DB::commit();
                return '/quotes';

            }catch (\Exception $e){
                DB::rollback();
                Session::push('error','Transaction error.');                
                return '/quotes/new/';
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
        error_log('update');
        $this->validateData($request, '/quotes-edit//'. $id);        

        $return =DB::transaction(function () use ($request, $id){
            $date = DateTime::createFromFormat('d/m/Y', $request->date);        
            $usableDate = $date->format('Y-m-d');

            try {
                error_log('trans');
                $quote = Quote::findOrFail($id);
                $quote->patient_id = $request->patient_id;
                $quote->date = $usableDate;
                $quote->sub_total = $request->subtotal;
                $quote->discount = $request->discount;
                $quote->final_price = $request->total;
                $quote->status = true;
                $quote->save();                

                Quote_Detail::where('quote_id', '=', $id)->delete();
                $item = 1;
                foreach ($request->dynamic as $items) {
                    if (count($request->dynamic) == 1 && $items == "") break;
                    $values = \explode('-', $items);
                    $q_detail = new Quote_Detail();
                    $q_detail->id = $item;
                    $q_detail->quote_id = $quote->id;
                    $q_detail->procedure_id = $values[0];
                    $q_detail->price = $values[1];
                    $q_detail->save();
                    $item++;
                }

                Session::push('success','Updated data.');
                DB::commit();
                return '/quotes';
            }catch (Exception $e){
                Session::push('error','Transaction error.');
                DB::rollback();
                error_log($e->getMessage());
                return '/quotes-edit//'. $id;                
            }
        });

        return redirect($return);
    }

    /**
     * Delete an item
     * @param $id
     * @return redirect to de list of the object
     */
    public function delete($id){
        if(Quote::where('id','=', $id)->first() === null){
            Session::push('error','Element not found.');
        }else{
            $return =DB::transaction(function () use ($id){
                try {
                    Quote::findOrFail($id)->delete();
                    Quote_Detail::where('quote_id', '=', $id)->delete();
                    Session::push('success','Deleted data.');
                    DB::commit();
                    return '/quotes';
                }catch (Exception $e){
                    Session::push('error','Transaction error.');
                    DB::rollback();
                    return '/quotes';
                }
            });
            return redirect($return);
        }
    }

    /**
     * Autocomplete the patient search for appointments
     * @return \Illuminate\Http\Response
     */
    public function searchQuoteDetail(Request $request){  
        try {         
            
            $det = DB::table('quote_detail')->join('procedures', 'quote_detail.procedure_id', '=', 'procedures.id')
            ->where('quote_detail.quote_id','=',$request->input('query'))->select('procedures.name')->get();
            
            return new JsonResponse($det);
        } catch (\Throwable $th) {            
            error_log($th->getMessage());
        }        
    }

    /**
     * Validate the options at the page
     * @param Request $request
     * @param array $redirect
     * @return mixed the address to be redirected with errors
     */
    private function validateData(Request $request, $redirect){   
        error_log($request);
        $validator = Validator::make($request->all(),
            ['name'=>'required|max:50', 'total'=>'required|numeric|min:0.01']);

        if($validator->fails()){
            Session::push('error','message');            
            return redirect($redirect)->withInput()->withErrors($validator);
        }
    }
  
}
