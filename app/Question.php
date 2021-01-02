<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table="questions";
    protected $primaryKey="id";
    protected $fillable =[
        'id',
        'title',
        'slug',
        'body',
        'views',
        'answers',
        'votes',
        'best_answer',
        'user_id',
        'created_at',
        'updated_at'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] =$value;
        $this->attributes['slug']=str_slug($value);
    }
    public function getUrlAttribute(){
        return route('questions.show',$this->slug);
    }
    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }
    //accessor start from get
    public function getStatusAttribute()
    {
        if($this->answers_count >0) {
           if($this->best_answer_id){
               return "answerd-accepted";
           }
            return "answered";
        }
        return "unanswered";
    }
    //accessor start from get
    public function getBodyHtmlAttribute()
    {
       //for install : composer require parsedown/laravel
        return \Parsedown::instance()->text($this->body);
    }
    public function answers(){
        return $this->hasMany(Answer::class);
    }
    //accept answer
    public function acceptBestAnswer(Answer $answer){
        $this->best_answer = $answer->id ;
        $this->save();
    }
}
