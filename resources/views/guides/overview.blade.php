@extends('layouts.master')

@section('title', 'Guides')

@section('serverdata')
    window.serverData = {!! \App\OneLiner::inRandomOrder()->whereGranted(1)->get()->first()->toJson() !!};
@endsection

@section('content')
    <gameguidesoverview></gameguidesoverview>
@endsection
