<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use VotableTrait;
    protected $fillable =['user_id', 'body'];
    protected $appends = ['created_date','body_html','is_best'];
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
        return clean(\Parsedown::instance()->text($this->body));
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($answer){
            $answer->question->increment('answers_count');
//            $answer->save();
        });
        static::deleted(function ($answer){

            $answer->question->decrement('answers_count');

        });
    }

    public function getStatusAttribute()
    {
        return $this->isBest() ? 'vote-accepted' : '';
    }
    public function getisBestAttribute()
    {
        return $this->isBest();
    }

    public function isBest( ){
        return $this->id === $this->question->best_answer;
    }




}
