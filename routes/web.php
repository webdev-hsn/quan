<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions','QuestionsController')->except('show');

Route::resource('questions.answers','AnswersController');

Route::get('/question/{slug}','QuestionsController@show')->name('question.show');

Route::post('/answers/accept/{answer}','AcceptedAnswerController@accept')->name('answers.accept');

//Favorite Fonctionality

Route::post('/questions/{id}/favorite','FavoriteController@store')->name('questions.favorite');

Route::delete('/questions/{id}/favorite','FavoriteController@destroy')->name('questions.unfavorite');

//Like & Dislike Fonctionalities

Route::post('/questions/{id}/vote','QuestionsVoteController@vote')->name('questions.vote');
Route::post('/answers/{id}/vote','AnswersVoteController@vote')->name('answers.vote');

