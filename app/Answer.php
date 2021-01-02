<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable =['user_id', 'body'];
    public function question(){
        return $this->belongsTo(Question::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
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
        static::deleted(function ($answer){
            $question=$answer->question;
            $question->decrement('answers_count');
            if($question->best_answer ===  $answer->id){
                $question->best_answer = null;
                $question->save();
            }
        });
    }

    public function getStatusAttribute()
    {
        return $this->id === $this->question->best_answer ? 'vote-accepted' : '';
    }


}
