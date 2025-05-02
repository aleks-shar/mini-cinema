@extends('admin::layouts.admin')

@section('title', 'Заблокировать эпизод')

@section('h1', 'Заблокировать эпизод')

@section('content')
    @include('abuse::category.episode.form')
    @include('abuse::category.episode.data')
@endsection
