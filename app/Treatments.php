<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Treatments_Detail;

class Treatments extends Model
{
    protected $table = 'treatments';

    public function patient(){
        return $this->belongsTo(Patients::class, 'patients_id');
    }

    public function details(){        
        return $this->hasMany(Treatments_Detail::class, 'treatments_id', 'id');
    }

}
