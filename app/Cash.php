<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $table = 'cash';

    public function receivable(){
        return $this->belongsTo(Receivable::class, 'receivable_id');
    }

    public function attention(){
        return $this->belongsTo(Attention::class, 'attention_id');
    }
}
