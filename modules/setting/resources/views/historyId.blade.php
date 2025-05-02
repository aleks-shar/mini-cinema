@use(App\Admin\Common\Facades\AppView)

@extends('admin::layouts.admin')

@section('title', 'История')

@section('h1', 'История')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="id">ID</label>
                                    <input type="text" name="id" class="form-control" value="{{ $data->id  }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="tag_id">Parameter ID</label>
                                    <input type="text" name="tag_id" class="form-control" value="{{ $data->tag_id}}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="domain">Домен</label>
                                    <input type="text" name="domain" class="form-control" value="{{ $data->domain  }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="old_key">Старое название</label>
                                    <input type="text" name="old_key" class="form-control" value="{{ $data->old_key  }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="new_key">Новое название</label>
                                    <input type="text" name="new_key" class="form-control" value="{{ $data->new_key  }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="old_value">Старое значение</label>
                                    <input type="text" name="old_value" class="form-control"
                                           value="{{ $data->old_value }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="new_value">Новое значение</label>
                                    <input type="text" name="new_value" class="form-control"
                                           value="{{ $data->new_value }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="old_description">Старое описание</label>
                                    <input type="text" name="old_description" class="form-control"
                                           value="{{ $data->old_description }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="new_description">Новое описание</label>
                                    <input type="text" name="new_description" class="form-control"
                                           value="{{ $data->new_description }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="created_at">Дата создания</label>
                                    <input type="text" name="created_at" class="form-control"
                                           value="{{ $data->created_at }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="email_update">Кто обновил</label>
                                    <input type="text" name="email_update" class="form-control"
                                           value="{{ AppView::getUserNameByEmail($data->email) }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="action">Действие</label>
                                    <input type="text" name="action" class="form-control" value="{{ $data->action }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="updated_at">Дата обновления</label>
                                    <input type="text" name="updated_at" class="form-control"
                                           value="{{ $data->updated_at }}" disabled>
                                </div>
                                <a href="{{ route('settings.history') }}" class="btn btn-info"
                                   title="">
                                    <i class="fas fa-reply">&nbsp;&nbsp;</i>
                                    Вернуться назад
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
