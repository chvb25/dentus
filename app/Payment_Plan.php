<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_Plan extends Model
{
    protected $table = 'payment_plan';

    public function receivable(){
        return $this->belongsTo(Receivable::class, 'receivable_id');
    }
}
