<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Parsedown; 
use Auth;
class Question extends Model
{
    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];

    protected $appends = ['body','fav_count','is_favorite'];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value)
    {
       $this->attributes['title'] = $value;
       $this->attributes['slug'] = str_slug($value);
    }

    public function getBodyAttribute($value)
    {
       return new HtmlString(
           app(Parsedown::class)->setSafeMode(true)->text($value));
       
    }
    public function favorites(){
        return $this->belongsToMany('App\User', 'favorites')->withTimeStamps();
    }

    public function getIsFavoriteAttribute(){

        return $this->favorites()->where('user_id',Auth::id())->count() > 0;
    }

    public function getFavCountAttribute(){
        return $this->favorites()->count();
    }

    public function user_votes(){
        return $this->morphToMany('App\User', 'votable');
      }
}
