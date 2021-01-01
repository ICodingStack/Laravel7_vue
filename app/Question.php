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
        return route('questions.show',$this->id);
    }
    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }
    //accessor start from get
    public function getStatusAttribute()
    {
        if($this->answers >0) {
           if($this->best_answer_id){
               return "answerd-accepted";
           }
            return "answered";
        }
        return "unanswered";
    }
}