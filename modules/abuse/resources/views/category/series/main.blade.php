@extends('admin::layouts.admin')

@section('title', 'Заблокировать сериал')

@section('h1', 'Заблокировать сериал')

@section('content')
    @include('abuse::category.series.form')
    @include('abuse::category.series.data')
@endsection
