<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answer';

    public function question(){
        return $this->belongsTo(Question::class, 'question_id');
    }
}
