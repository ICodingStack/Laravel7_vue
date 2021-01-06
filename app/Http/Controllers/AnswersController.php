<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Auth;

class AnswersController extends Controller
{




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question,Request $request)
    {

        $question->answers()->create($request->validate([
            'body' => 'required'
            ]) + ['user_id' => \Auth::id()]);
        return back()->with('success','Your Answer has been submitted successfully');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question,Answer $answer)
    {
        $this->authorize('update',$answer);
        return view('answers._edit',compact('question','answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Question $question,Answer $answer)
    {
        $this->authorize('update',$answer);
        $answer->update($request->validate([
            'body'=>'required',
        ]));
       // return redirect()->route('questions.show',$question->slug)->with('success','your answer has been updated');
        if($request->expectsJson()){
            return response()->json([
                'message' => 'your answer has been updated',
                'body_html' => $answer->body_html
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question,Answer $answer)
    {
        $this->authorize('delete',$answer);
        $answer->delete();
        if(request()->expectsJson()){
            return response()->json([
                'message' =>'Your Answer Has been removed !'
            ]);
        }
        return back()->with('success','Your Answer Has been removed !');
    }
}
