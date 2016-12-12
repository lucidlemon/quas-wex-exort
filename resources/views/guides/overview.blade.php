@extends('layouts.master')

@section('title', 'Guides')

@section('bodyclass', 'guides')

@section('serverdata')
    window.serverData = {
        latestGuides: {!! \App\Guide::orderBy('created_at', 'desc')->limit(5)->with(['guide_type', 'morphable'])->get()->toJson() !!},
        guide_types: {!! \App\GuideType::all()->toJson() !!},
        patches: {!! \App\Patch::all()->toJson() !!},
    };
@endsection

@section('content')
    <gameguidesoverview></gameguidesoverview>
@endsection
