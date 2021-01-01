<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Question;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //install debug bar
        //composer require barryvdh/laravel-debugbar --dev
//        --
        //return view without type return must use render
      // \DB::enableQueryLog();
         //view('questions.index',compact('questions'))->render();
        // dd(\DB::getQueryLog());
        $questions =Question::with('user')->latest()->paginate(5);
       return  view('questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question= new Question();
        return view('questions.create',compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title','body'));
        return redirect()->route('questions.index')->with('success','your question has been submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
      //increment views
        $question->increment('views');
        return  view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $response = Gate::inspect('update-question', $question);
        if($response->allowed()){
            return view('questions.edit',compact('question'));
        }
        abort(403,'Access denied');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $response = Gate::inspect('update-question', $question);
        if($response->allowed()){
            $question->update($request->only('title','body'));
            return redirect()->route('questions.index')->with('success','your question has been updated.');
        }
        abort(403,'Access denied');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $response = Gate::inspect('delete-question', $question);
        if($response->allowed()){
            $question->delete();
            return redirect()->route('questions.index')->with('success','your question has been deleted.');
        }
        abort(403,'Access denied');

    }
}
