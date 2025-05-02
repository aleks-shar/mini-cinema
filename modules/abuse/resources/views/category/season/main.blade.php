@extends('admin::layouts.admin')

@section('title', 'Заблокировать сезон')

@section('h1', 'Заблокировать сезон')

@section('content')
    @include('abuse::category.season.form')
    @include('abuse::category.season.data')
@endsection
