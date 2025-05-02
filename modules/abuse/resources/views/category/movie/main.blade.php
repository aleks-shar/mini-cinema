@extends('admin::layouts.admin')

@section('title', 'Заблокировать фильм')

@section('h1', 'Заблокировать фильм')

@section('content')
    @include('abuse::category.movie.form')
    @include('abuse::category.movie.data')
@endsection
