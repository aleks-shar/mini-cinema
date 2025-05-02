@extends('admin::layouts.admin')

@section('title', 'Заблокировать')

@section('h1', 'Заблокировать')

@section('content')
    @include('abuse::common.form')
    @include('abuse::common.data')
@endsection
