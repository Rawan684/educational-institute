@extends('classes::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('classes.name') !!}</p>
@endsection
