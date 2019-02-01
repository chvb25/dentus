<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receivable extends Model
{
    protected $table = 'receivable';

    public function attention(){
        return $this->belongsTo(Attention::class, 'attention_id');
    }
}
