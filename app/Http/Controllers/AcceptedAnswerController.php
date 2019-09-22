<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;

class AcceptedAnswerController extends Controller
{
    public function accept(Answer $answer){
        $answer->question->best_answer_id = $answer->id;
        $answer->question->save();
        return back();
    }
}
