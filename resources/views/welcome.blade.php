@extends('layouts.master')

@section('title', 'Time to Kiev Major')

@section('bodyclass', 'counter')


@section('content')
    <countdown manual="{{ $manual }}"></countdown>
@endsection
