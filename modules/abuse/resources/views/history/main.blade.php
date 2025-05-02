@extends('admin::layouts.admin')

@section('title', 'История')

@section('h1', 'История')

@section('content')
    @include('abuse::history.filter')
    @include('abuse::history.data')
@endsection
