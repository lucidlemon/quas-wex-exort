@extends('layouts.master')

@section('title', 'Oneliners')

@section('serverdata')
    window.serverData = {
        guide_types: {!! \App\GuideType::all()->toJson() !!},
        patches: {!! \App\Patch::all()->toJson() !!},
        morphs: {!! json_encode($morphs) !!},
    }
@endsection

@section('content')
    <gameguidescreate></gameguidescreate>
@endsection
