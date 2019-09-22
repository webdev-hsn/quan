@extends('layouts.app')

@section('content')

    <div class="container-fluid mt-5 pl-5">

    
            
   

        <div class="row">
            <div class="col-md-7">
                
                
                 <div class="media mb-1 rounded bg-white p-3 shadow-sm">
                    <div class="media-body">
                        <h1><strong> {{str_replace('.','?',$question->title)}} </strong></h1>
                    </div>
                 </div>
                <div class="media mb-5 rounded bg-white p-3 shadow-sm">
                    <img class="mr-3 rounded" src="{{$question->user->avatar}}&s=50" alt="Generic placeholder image">
                    
                    <div class="media-body">
                        
                        <h5 class="ml-0 mb-0"><strong>{{$question->user->name}}</strong></h5>
                        <p class="small">Asked {{$question->created_at->DiffForHumans()}} </p>
                        
                        <p class="lead mt-3"> {{$question->body}} </p>
                        <hr>
                        <div class="d-flex float-left">
                        <p class="small text-muted mb-0 mr-2"> <i class="fa fa-lg fa-eye"> </i> {{$question->views_count}}</p>
                        <p class="small text-muted mb-0"> <i class="fa fa-lg fa-comments"> </i> {{$question->answers_count}}</p>

                        </div>
                        <div class="d-flex float-left ml-5">
                        <p class="small mb-0 mr-2"> <i class="fa fa-2x fa-facebook-square"> </i> </p>
                        <p class="small mb-0 mr-2"> <i class="fa fa-2x fa-twitter-square"> </i> </p>
                        <p class="small mb-0 mr-2"> <i class="fa fa-2x fa-pinterest-square"> </i> </p>
                        <p class="small mb-0 mr-2"> <i class="fa fa-2x fa-telegram"> </i> </p>

                        </div>
                        <!-- Edit & Delete Btns -->
                        @if(Auth::id() == $question->user->id) 
                        <div class="d-flex float-right">
                        <a href="{{route('questions.edit',$question->id)}}"> <button class="mr-1 d-inline btn btn-sm btn-outline-info"> <i class="fa fa-pencil"></i></button> </a>
                        <form action="{{route('questions.destroy',$question->id)}}" method="post">
                            @method('DELETE')
                            @csrf 
                            <button type="submit" class="btn btn-sm btn-outline-danger d-inline"> <i class="fa fa-trash"></i></button>
                        </form>
                        </div>
                         @endif   
                        <!---->
                        
                        <!-- Vote Elements -->
                        <div class="d-inline float-right">
                        <span class="badge badge-pill badge-secondary">{{$question->user_votes()->wherePivot('vote',1)->count()}}</span>
                            <a href="#" class="vote-up"
                            onclick = "event.preventDefault(); document.getElementById('vote-up-question-{{ $question->id }}').submit();">
                                <i class="fa fa-lg text-secondary fa-thumbs-up mr-2 {{ Auth::check() ? Auth::user()->question_vote_status($question,1) : '' }}"> 
                                </i>
                            </a>
                            <form id="vote-up-question-{{ $question->id }}" action="{{ route('questions.vote',$question->id)}}" method="post" style="display:none;">
                            @csrf 
                            <input type="hidden" name="vote" value="1">
                            </form>

                            <span class="badge badge-pill badge-secondary">{{$question->user_votes()->wherePivot('vote',-1)->count()}}</span>
                            <a href="#" class="vote-down"
                            onclick = "event.preventDefault(); document.getElementById('vote-down-question-{{ $question->id }}').submit();">
                                <i class="fa fa-lg text-secondary fa-thumbs-down mr-2 {{ Auth::check() ? Auth::user()->question_vote_status($question,-1) : ''  }}"> 
                                </i>
                            </a>
                            <form id="vote-down-question-{{ $question->id }}" action="{{ route('questions.vote',$question->id)}}" method="post" style="display:none;">
                            @csrf 
                            <input type="hidden" name="vote" value="-1">
                            </form>

                            <favorite :question = "$question" ></favorite> 
                            
                            <form action="/questions/{{$question->id}}/favorite" method="post" id="favorite-{{$question->id }}" style="display:none;">
                            @csrf 
                            @if($question->is_favorite)
                                @method('DELETE')
                            @endif
                            </form>
                        </div>
                        <!-- -->
                    </div>
                </div>
                <form class="form" action="{{route('questions.answers.store',$question->id)}}" method="post">
                    @csrf 
                    <div class="form-group">
                        <label for="body">Answer this question</label>
                        <textarea class="form-control" name="body" id="body" cols="5" rows="7"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-outline-success" type="submit">Publish Answer</button>
                    </div>
                </form>
                <!--Material textarea-->
                

                <div class="media mb-1 rounded bg-white p-0 shadow-sm">
                    <div class="media-body">
                        <p class="mt-3 ml-3"> {{$question->answers_count}} {{str_plural('Answer',$question->answers_count)}} </p>
                    </div>
                 </div>
                @foreach($question->answers as $answer)
                <div class="media mb-1 rounded bg-white p-3 shadow-sm">
                    <img class="mr-3 mt-1 rounded" src="{{$answer->user->avatar}}&s=30" alt="Generic placeholder image">
                    <div class="media-body">
                        <p class="ml-0 mb-0"><strong>{{$answer->user->name}}</strong>
                        <br>
                        <p style="font-size:11px;" class="">Answered {{$answer->created_at->DiffForHumans()}} </p>
                        </p>
                        <p class="text-muted mt-1 mt-3"> {{$answer->body}} </p>
                        <hr>
                        <!-- Vote Elements -->
                        
                        <div class="d-inline float-right">
                        <span class="badge badge-pill badge-secondary">{{$answer->user_votes()->wherePivot('vote',1)->count()}}</span>
                            <a href="#" class="vote-up"
                        onclick = "event.preventDefault(); document.getElementById('vote-up-answer-{{ $answer->id }}').submit();">
                        <i class="fa text-secondary fa-thumbs-up mr-2 {{ Auth::check() ? Auth::user()->answer_vote_status($answer,1) : '' }}"> 
                        </i>
                        </a>
                        <form id="vote-up-answer-{{ $answer->id }}" action="{{ route('answers.vote',$answer->id)}}" method="post" style="display:none;">
                        @csrf 
                        <input type="hidden" name="vote" value="1">
                        </form>

                        <span class="badge badge-pill badge-secondary">{{$answer->user_votes()->wherePivot('vote',-1)->count()}}</span>
                        <a href="#" class="vote-down"
                        onclick = "event.preventDefault(); document.getElementById('vote-down-answer-{{ $answer->id }}').submit();">
                        <i class="fa text-secondary fa-thumbs-down mr-2 {{ Auth::check() ?  Auth::user()->answer_vote_status($answer,-1) : '' }}"> 
                        </i>
                        </a>
                        <form id="vote-down-answer-{{ $answer->id }}" action="{{ route('answers.vote',$answer->id)}}" method="post" style="display:none;">
                        @csrf 
                        <input type="hidden" name="vote" value="-1">
                        </form>



                           @if(Auth::id() == $question->user_id)
                            <a title="Mark as Best answer" class="vote-down"
                            onclick =" document.getElementById('accept-answer-{{$answer->id}}').submit();">
                             <i class="fa fa-2x text-secondary fa-check {{$answer->status}} best-answer"> 
                                </i>
                            </a> 
                            <form id="accept-answer-{{$answer->id}}" action="{{route('answers.accept',$answer->id)}}" method="post" style="display:none;" >
                            @csrf 
                            </form>
                            @elseif($answer->status == 'accepted')
                            <a title="Mark as Best answer" class="vote-down">
                             <i class="fa fa-2x text-secondary fa-check {{$answer->status}} best-answer"> 
                                </i>
                            </a>
                            @endif                     
                        </div>
                        <!-- -->
                    </div>
                </div>
                
                @endforeach
            </div>
            <div class="col-md-5">

            </div>
        </div>
        
        
    </div>


@endsection