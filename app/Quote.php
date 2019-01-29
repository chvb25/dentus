<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'quote';

    public function patient(){
        return $this->belongsTo(Patients::class, 'patient_id');
    }
    
    public function details()
    {
        return $this->hasMany(Quote_Detail::class, 'quote_id', 'id');
    }
    
}

