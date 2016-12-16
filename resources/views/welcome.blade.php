@extends('layouts.master')

@section('title', 'Countdown')

@section('bodyclass', 'counter')


@section('content')
    <countdown manual="{{ $manual }}"></countdown>
@endsection
