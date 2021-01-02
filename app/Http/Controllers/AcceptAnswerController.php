<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class AcceptAnswerController extends Controller
{
    // if i define route without method name the method will be the __invoke()
    public function __invoke(Answer $answer){

        $this->authorize('accept',$answer);
        $answer->question->acceptBestAnswer($answer);
        return back();
    }
}
