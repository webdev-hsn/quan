<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['body','user_id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function($answer){
            $answer->question->increment('answers_count');
        });

    }

    public function getStatusAttribute(){
        if($this->id === $this->question->best_answer_id){
            return 'accepted';
        }
        return '';
    }

    public function user_votes(){
        return $this->morphToMany('App\User', 'votable');
      }
}
