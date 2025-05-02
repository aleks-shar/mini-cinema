@use(App\Admin\Common\Enums\ResourseType)

@extends('admin::layouts.admin')

@section('title', 'Задать индивидуальные мета-теги')

@section('h1', 'Задать индивидуальные мета-теги')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <a href="{{ route('individual-all') }}" class="btn btn-info mb-3">Список
                        мета-тегов</a>
                    <a href="{{ route('individual-history') }}" class="btn btn-success ml-3 mb-3">История</a>
                    <div class="card card-primary">
                        <form action="{{ route('seo.individual.common.title') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Название</label>
                                    <input type="text" name="title" class="form-control"
                                           placeholder="Input name"
                                           value="@if(isset($title)){{$title}}@endif">
                                </div>
                                <div class="form-group">
                                    <label for="type2">Тип контента</label>
                                    <select name="type2" class="form-control">
                                        <option value={{ ResourseType::MOVIE }}>{{ ResourseType::MOVIE }}</option>
                                        <option value={{ ResourseType::SERIES }}>{{ ResourseType::SERIES }}</option>
                                        <option value={{ ResourseType::SEASON }}>{{ ResourseType::SEASON }}</option>
                                        <option value={{ ResourseType::EPISODE }}>{{ ResourseType::EPISODE }}</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search">&nbsp;&nbsp</i>Найти
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
