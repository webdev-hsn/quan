<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\User;
use App\Question;
use Auth;

class FavoriteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function store( $id){

        $question = Question::find($id);
        $question->favorites()->attach(Auth::id());

        return back();
    }

    public function destroy($id){
        $question = Question::find($id);
        $question->favorites()->detach(Auth::id());

        return back();
    }
}
