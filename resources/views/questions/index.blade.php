@extends('layouts.app')


@section('content')

    

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-6">
           @if(Auth::check())
           <div class="media mb-5 rounded bg-white p-2 shadow-sm border border-info">
        <img class="mr-3 rounded" src="{{$user->avatar}}&s=30" alt="Generic placeholder image">
        
        <div class="media-body">
            <p class="ml-0 mb-0"><strong>{{$user->name}}</strong></p>
            <a href="{{route('questions.create')}}">
            <h5 class="text-muted mt-1"> <strong> Do you have any question? Ask and let people Answer you. </strong></h5>
            </a>
        </div>
        
    </div>
           @endif
    
    @if(session('success'))
        
    <div class="alert alert-success alert-dismissible show fade">
                {{ session('success') }} @if(session('slug')) click <a href="/question/{{session('slug')}}">here</a> to see it. @endif 
            </div>
    @endif
    @foreach($questions as $question)
    
    <div class="media mb-3 rounded bg-white p-3 shadow-sm border border-light">
        <img class="mr-3 rounded" src="{{$question->user->avatar}}&s=40" alt="Generic placeholder image">
        <div class="media-body ">
            <h4 class="mt-0 mb-0"><strong> <a class="text-dark" href="{{route('question.show',$question->slug)}}"> {{$question->title}} </a></strong></h4>
            {!! str_limit($question->body,120) !!}
            <p class="mt-2 mb-0 font-weight-lighter text-muted"> {{$question->answers_count}} {{str_plural('Answer',$question->answers_count)}}</p>

        </div>
    </div>
    @endforeach
    
    {{$questions->render()}}
    
    
    </div>
    <div class="col-md-3">

</div>
    </div>
    </div>



@endsection