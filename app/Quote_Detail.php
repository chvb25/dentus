<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote_Detail extends Model
{
    protected $table = 'quote_detail';    

    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }

    public function procedure()
    {
        return $this->belongsTo(Procedures::class, 'procedure_id');
    }
}
