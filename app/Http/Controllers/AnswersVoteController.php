<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class AnswersVoteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function vote( $id ){
        $vote = request()->vote;
        $user = auth()->user();
        $user->voteAnswer($id, $vote);

        return back();
    }
}
