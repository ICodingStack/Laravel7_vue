@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <div class="col-md-10">
                                    <h1>{{ $question->title }}</h1>
                                </div>
                                <div class="ml-auto">
                                <div class="ml-auto">
                                    <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">
                                        Back To All Questions
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="media">
                           <vote :model="{{ $question }}"  name="question" />
                            <div class="media-body">
                                {!! $question->body_html !!}
                               <div class="row">
                                   <div class="col-md-4"></div>
                                   <div class="col-md-4"></div>
                                   <div class="col-md-4">
                                   <user-info :model="{{ $question }}" label="asked" />
                                   </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <answers :question=" {{ $question }} " />
        </div>


    </div>
@endsection
