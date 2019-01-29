<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatments_Detail extends Model
{
    protected $table = 'treatments_detail';
    protected $appends = ['procedureName', 'procedureStatus'];

    public function treatment()
    {
        return $this->belongsTo(Treatments::class, 'treatments_id');
    }

    public function procedure()
    {
        return $this->belongsTo(Procedures::class, 'procedure_id');
    }

    public function getProcedureNameAttribute(){
        $completeName = "Revision";
        if($this->procedure){
            $completeName = $this->procedure->name;
        }
        return $completeName;
    }

    public function getProcedureStatusAttribute(){
        $status = 0;
        if($this->procedure){
            $status = $this->procedure->status;
        }
        return $status;
    }
}
