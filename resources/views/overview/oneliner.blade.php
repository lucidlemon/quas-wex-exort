@extends('layouts.master')

@section('title', 'Oneliners')

@section('serverdata')
    window.serverData = {!! \App\OneLiner::inRandomOrder()->whereGranted(1)->get()->first()->toJson() !!};
@endsection

@section('content')
    <oneliners></oneliners>
@endsection
