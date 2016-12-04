@extends('layouts.master')

@section('title', 'Guides')

@section('bodyclass', 'guides')

@section('serverdata')
    window.serverData = {
        guides: {!! $guides->toJson() !!},
    }
@endsection


@section('content')
    <gameguideslist category="{{ $category }}"></gameguideslist>
@endsection
