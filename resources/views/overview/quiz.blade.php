@extends('layouts.master')

@section('title', 'Quiz')

@section('serverdata')
    window.serverData = {!! json_encode((object)['quizSession' => $quizSession, 'quizMmr' => $mmr]) !!};
@endsection

@section('content')
    <quiz></quiz>
@endsection
