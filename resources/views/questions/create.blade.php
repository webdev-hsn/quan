@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <div class="row">
        <div class="col-md-3"></div>

        <div class="col-md-6">

            <form action="{{route('questions.store')}}" method="post" class="mt-5">
                @csrf 
                <div class="form-group ">
                <label for="title">What is your question?</label>
                <input class="form-control {{$errors->has('title') ? ' is-invalid' : ''}}" type="text" value="{{old('title')}}" name="title" id="title">
                @if ($errors->has('title')) <p class="text-danger">{{ $errors->first('title') }}</p> @endif
            </div>

                <div class="form-group">
                <label for="body">Tell us more about it </label>
                <textarea class="form-control {{$errors->has('body') ? ' is-invalid' : ''}}" name="body" id="body" value="{{old('body')}}" rows="7">

                </textarea>
                @if ($errors->has('body')) <p class="text-danger">{{ $errors->first('body') }}</p> @endif

                </div>

                <div class="form-group">
                <button class="btn btn-outline-success" type="submit">Publish</button>
                </div>
                

                
            </form>

        </div>
        <div class="col-md-3"></div>
        </div>
    </div>

















@endsection