<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';

    public function question_type(){
        return $this->belongsTo(Question_Type::class, 'question_type_id');
    }

    public function answers(){
        return $this->hasMany(Answer::class, 'question_id');
    }
}
