@extends('layouts.app')

@section('content')
        <question-page :question="{{ $question }} " />
@endsection
