<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class QuestionsVoteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function vote($id){
        $vote = request()->vote;
        $user = auth()->user();
        $user->voteQuestion($id, $vote);

        return back();
        }
       
}
