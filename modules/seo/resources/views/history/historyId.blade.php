@use(App\Admin\Common\Facades\AppView)

@extends('admin::layouts.admin')

@section('title', 'История')domain

@section('h1')
    История
@endsection

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
                                    <label for="domain">Домен</label>
                                    <input type="text" name="domain" class="form-control" value="{{ $data->domain  }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="action">Действие</label>
                                    <input type="text" name="action" class="form-control" value="{{ $data->action  }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="type">Тип</label>
                                    <input type="text" name="type" class="form-control" value="{{ $data->type  }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="name">Название</label>
                                    <input type="text" name="name" class="form-control" value="{{ $data->name  }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="season">Сезон</label>
                                    <input type="text" name="season" class="form-control" value="{{ $data->season  }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="episode">Эпизод</label>
                                    <input type="text" name="episode" class="form-control" value="{{ $data->episode }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="h1">h1</label>
                                    <input type="text" name="h1" class="form-control" value="{{ $data->h1 }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="title">title</label>
                                    <input type="text" name="title" class="form-control" value="{{ $data->title }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="description">description</label>
                                    <input type="text" name="description" class="form-control"
                                           value="{{ $data->description }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="keywords">keywords</label>
                                    <input type="text" name="keywords" class="form-control"
                                           value="{{ $data->keywords }}" disabled>
                                </div>
                                @if($data->type === 'selection')
                                    <div class="form-group">
                                        <label for="image">image</label>
                                        <input type="text" name="image" class="form-control" value="{{ $data->image }}"
                                               disabled>
                                    </div>
                                @endif
                                @if($data->type === 'movie' || $data->type === 'series' || $data->type === 'trailer' || $data->type === 'selection')
                                    <div class="form-group">
                                        <label for="text">Описание @if($data->type === 'movie')
                                                фильма
                                            @endif @if($data->type === 'trailer')
                                                трейлера
                                            @endif @if($data->type === 'series')
                                                сериала
                                            @endif</label>
                                        <textarea disabled rows="10" name="text"
                                                  class="form-control">{{ $data->text }}</textarea>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="og_title">Open Graph Title</label>
                                    <input type="text" name="og_title" class="form-control"
                                           value="{{ $data->og_title }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="og_description">Open Graph Description</label>
                                    <input type="text" name="og_description" class="form-control"
                                           value="{{ $data->og_description }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="email_update">Кто обновил</label>
                                    <input type="text" name="email_update" class="form-control"
                                           value="{{ AppView::getUserNameByEmail($data->email) }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="updated_at">Дата обновления</label>
                                    <input type="text" name="updated_at" class="form-control"
                                           value="{{ $data->updated_at }}" disabled>
                                </div>
                                <a href="{{ route('individual-history') }}" class="btn btn-info" title=""><i
                                            class="fas fa-reply">&nbsp;&nbsp;</i>Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
