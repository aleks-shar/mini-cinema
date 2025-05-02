@extends('admin::layouts.admin')

@section('title', 'Создать параметр')

@section('h1', 'Создать параметр')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <form action="{{ route('settings.store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="key">Параметр (*)</label>
                                    <input type="text" name="key" class="form-control"
                                           placeholder="Введите название">
                                </div>
                                <div class="form-group">
                                    <label for="value">Значение (*)</label>
                                    <input type="text" name="value" class="form-control"
                                           placeholder="Введите значение">
                                </div>
                                <div class="form-group">
                                    <label for="description">Описание</label>
                                    <input type="text" name="description" class="form-control"
                                           placeholder="Введите описание">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success"><i class="fas fa-save">&nbsp;&nbsp;</i>Сохранить
                                </button>
                                <br/>
                                <br/>
                                (*) - Обязательные поля для заполнения
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
