@use(App\Admin\Common\Facades\AppView)

@extends('admin::layouts.admin')

@section('title', 'Редактирование')

@section('h1')
    Редактировать параметр {{ $settings->key }}
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <form action="{{ route('settings.update', [$settings->id]) }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="id">Parameter ID</label>
                                    <input type="text" name="id" class="form-control" value="{{ $settings->id }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="key">Параметр (*)</label>
                                    <input type="text" name="key" class="form-control"
                                           placeholder="Введите название" value="{{ $settings->key  }}"
                                           @if(auth()->guard('admin')->user()->role !== 'admin')
                                               disabled
                                            @endif>
                                </div>
                                <div class="form-group">
                                    <label for="value">Значение (*)</label>
                                    <input type="text" name="value" class="form-control"
                                           placeholder="Введите значение" value="{{ $settings->value }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Описание</label>
                                    <input type="text" name="description" class="form-control"
                                           placeholder="Введите описание"
                                           value="{{ $settings->description }}">
                                </div>
                                <div class="form-group">
                                    <label for="email_create">Кто создал</label>
                                    <input type="text" name="email_create" class="form-control"
                                           value="{{ AppView::getUserNameByEmail($settings->email_create) }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="created_at">Дата создания</label>
                                    <input type="text" name="created_at" class="form-control"
                                           value="{{ $settings->created_at }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="email_update">Кто изменил</label>
                                    <input type="text" name="email_update" class="form-control"
                                           value="{{ AppView::getUserNameByEmail($settings->email_update) }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="updated_at">Дата изменения</label>
                                    <input type="text" name="updated_at" class="form-control"
                                           value="{{ $settings->updated_at }}" disabled>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('settings.show') }}" class="btn btn-info" title=""><i
                                            class="fas fa-reply">&nbsp;&nbsp;</i>Вернуться назад</a>
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
