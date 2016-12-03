@extends('layouts.master')

@section('title', 'Dota 6.89 / 7.00 Countdown')

@section('bodyclass', 'counter')


@section('content')
    <countdown manual="{{ $manual }}"></countdown>
@endsection
