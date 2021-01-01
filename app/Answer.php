<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function question(){
        return $this->belongsTo(Question::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    //accessor start from get
    public function getBodyHtmlAttribute()
    {
        //for install : composer require parsedown/laravel
        return \Parsedown::instance()->text($this->body);
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($answer){
            $answer->question->increment('answers_count');
//            $answer->save();
        });
    }

}
