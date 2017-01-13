@extends('layouts.master')

@section('title', 'Post a new Guide')

@section('serverdata')
    window.serverData = {
        guideTypes: {!! \App\GuideType::all()->toJson() !!},
        patches: {!! \App\Patch::orderBy('started_at', 'desc')->get()->toJson() !!},
        morphs: {!! json_encode($morphs) !!},
    }
@endsection

@section('content')
    <gameguidescreate></gameguidescreate>
@endsection
