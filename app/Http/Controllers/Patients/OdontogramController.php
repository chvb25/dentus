<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Odontogram;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use Validator;


class OdontogramController extends Controller
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

    /**
     * Get the list of tooth that are at the odontogram of the patient
     *
     */
    public function getTeeth(Request $request){
        try {
            $data = DB::table('odontogram')
            ->join('procedures', 'odontogram.procedure_id', '=', 'procedures.id')
            ->where('patients_id', '=', "{$request->input('query')}")
            ->select('procedures.id', 'procedures.type', 'odontogram.tooth', 'procedures.color')->get();
            return response()->json($data);
        } catch (\Throwable $th) {
            error_log($th->message);
        }
    }


}
