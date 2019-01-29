<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    protected $table = 'appointments';
    protected $appends = ['patientId', 'completeName', 'procedureName', 'procedureColor', 'procedureType'];

    public function treatment(){
        return $this->belongsTo(Treatments::class, 'treatments_id');
    }

    public function procedure_data(){
        return $this->belongsTo(Procedures::class, 'procedure_id');
    }

    public function patient_data()
    {
        return $this->belongsTo('App\Patients', 'treatments_id');
    }

    public function getPatientIdAttribute(){
        $id = null;
        if($this->treatment){
            $id = $this->treatment->patient->id;
        }else {
            $id = $this->patient_data->id;
        }
        return $id;
    }

    public function getCompleteNameAttribute(){
        $completeName = null;
        if($this->treatment){
            $completeName = $this->treatment->patient->completeName;
        }else {
            $completeName = $this->patient_data->completeName;
        }
        return $completeName;
    }

    public function getProcedureNameAttribute(){
        $procedureName = "Revision";
        if($this->procedure_data){
            $procedureName = $this->procedure_data->name;
        }
        return $procedureName;
    }

    public function getProcedureColorAttribute(){
        $procedureColor = "#fff";
        if($this->procedure_data){
            $procedureColor = $this->procedure_data->color;
        }
        return $procedureColor;
    }
    public function getProcedureTypeAttribute(){
        $procedureType = "P";
        if($this->procedure_data){
            $procedureType = $this->procedure_data->type;
        }
        return $procedureType;
    }
}
