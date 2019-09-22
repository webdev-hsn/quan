<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function getAvatarAttribute()
    {
        $avatar = md5($this->attributes['email']);
        return "http://www.gravatar.com/avatar/$avatar?d=retro";

    }
    public function favorites(){
      return $this->belongsToMany('App\Question', 'favorites')->withTimeStamps();
    }

    public function voteQuestions(){
        return $this->morphedByMany('App\Question', 'votable');
      }
      public function voteAnswers(){
        return $this->morphedByMany('App\Answer', 'votable');
      }
      public function voteQuestion($id, $vote){
          $questionVotes = $this->voteQuestions();

          if($questionVotes->wherePivot('votable_id',$id)->exists()){
              $questionVotes->updateExistingPivot($id, ['vote' => $vote]);
          }
          else{
              $questionVotes->attach($id,['vote' => $vote]);
          }
      }

      public function question_vote_status(Question $question, $vote){
        if($this->voteQuestions()->where(['votable_id'=> $question->id, 'vote' => $vote])->exists() )
        {
            return 'liked';
        } 
        else{
            return '';
        }
      }

      public function answer_vote_status(Answer $answer, $vote){
        if($this->voteAnswers()->where(['votable_id'=> $answer->id, 'vote' => $vote])->exists() )
        {
            return 'liked';
        } 
        else{
            return '';
        }
      }


      public function voteAnswer($id, $vote){
        $answerVotes = $this->voteAnswers();

        if($answerVotes->wherePivot('votable_id',$id)->exists()){
            $answerVotes->updateExistingPivot($id, ['vote' => $vote]);
        }
        else{
            $answerVotes->attach($id,['vote' => $vote]);
        }
    }
}
