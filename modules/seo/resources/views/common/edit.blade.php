@use(App\Admin\Common\Facades\AppView)

@extends('admin::layouts.admin')

@section('title', 'Edit')

@section('h1')
    Edit tags {{ $seo->alias }}
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <form action="{{ route('seo.update', [$seo->id]) }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="id">TAG ID</label>
                                    <input type="text" name="id" class="form-control" value="{{ $seo->id  }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="h1">H1</label>
                                    <input type="text" name="h1" class="form-control"
                                           placeholder="Input H1" value="{{ $seo->h1  }}">
                                </div>
                                <div class="form-group">
                                    <label for="title">Title (*)</label>
                                    <input type="text" name="title" class="form-control"
                                           placeholder="Input title" value="{{ $seo->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description (*)</label>
                                    <input type="text" name="description" class="form-control"
                                           placeholder="Input description" value="{{ $seo->description }}">
                                </div>
                                <div class="form-group">
                                    <label for="keywords">Keywords</label>
                                    <input type="text" name="keywords" class="form-control"
                                           placeholder="Input keywords" value="{{ $seo->keywords }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Кто обновил</label>
                                    <input type="text" name="email" class="form-control"
                                           value="{{ AppView::getUserNameByEmail((string)$seo->email) }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="updated_at">Дата обновления</label>
                                    <input type="text" name="updated_at" class="form-control"
                                           value="{{ $seo->updated_at }}" disabled>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('seo.show') }}" class="btn btn-info"><i
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
