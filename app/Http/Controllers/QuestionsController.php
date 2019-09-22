<?php

namespace App\Http\Controllers;

use App\Question;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $questions = Question::OrderBy('answers_count','desc')->Paginate(10);
       $user = Auth::user();
       return view('questions.index', compact('questions','user'));
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $request->user()->questions()->create($request->all());
        $slug = str_slug($request->title);

        return redirect()->route('questions.index')->with('success',"Your Question has been published.")->with('slug',$slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views_count');
        return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        return view('questions.edit',compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question) {

        $this->authorize('update',$question);

        $question->update($request->only('title','body'));

        return redirect(route('questions.index'))->with('success','Your question has been updated.')->with('slug',$question->slug);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $this->authorize('delete',$question);
        $question->delete();
        return redirect(route('questions.index'))->with('success','your question has been deleted');
    }
}
