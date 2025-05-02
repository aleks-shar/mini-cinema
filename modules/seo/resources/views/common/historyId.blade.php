@use(App\Admin\Common\Facades\AppView)
@extends('admin::layouts.admin')

@section('title', 'История')

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
                                    <label for="tag_id">Tag ID</label>
                                    <input type="text" name="tag_id" class="form-control" value="{{ $data->tag_id  }}"
                                           disabled>
                                </div>
                                <div class="form-group mb-5">
                                    <label for="alias">Alias</label>
                                    <input type="text" name="alias" class="form-control" value="{{ $data->alias  }}"
                                           disabled>
                                </div>
                                @if($data->old_h1 != $data->new_h1)
                                    <div class="form-group">
                                        <label for="old_h1">Старое значение h1</label>
                                        <input type="text" name="old_h1" class="form-control"
                                               style="background-color: #e8b0b0;" value="{{ $data->old_h1  }}" disabled>
                                    </div>
                                    <div class="form-group mb-5">
                                        <label for="new_h1">Новое значение h1</label>
                                        <input type="text" name="new_h1" class="form-control"
                                               style="background-color: #c6f5d0" value="{{ $data->new_h1  }}" disabled>
                                    </div>
                                @endif
                                @if($data->old_title != $data->new_title)
                                    <div class="form-group">
                                        <label for="old_title">Старое значение title</label>
                                        <input type="text" name="old_title" class="form-control"
                                               style="background-color: #e8b0b0;" value="{{ $data->old_title }}"
                                               disabled>
                                    </div>
                                    <div class="form-group mb-5">
                                        <label for="new_title">Новое значение title</label>
                                        <input type="text" name="new_title" class="form-control"
                                               style="background-color: #c6f5d0" value="{{ $data->new_title }}"
                                               disabled>
                                    </div>
                                @endif
                                @if($data->old_description != $data->new_description)
                                    <div class="form-group">
                                        <label for="old_description">Старое значение description</label>
                                        <input type="text" name="old_description" class="form-control"
                                               style="background-color: #e8b0b0;" value="{{ $data->old_description }}"
                                               disabled>
                                    </div>
                                    <div class="form-group mb-5">
                                        <label for="new_description">Новое значение description</label>
                                        <input type="text" name="new_description" class="form-control"
                                               style="background-color: #c6f5d0" value="{{ $data->new_description }}"
                                               disabled>
                                    </div>
                                @endif
                                @if($data->old_keywords != $data->new_keywords)
                                    <div class="form-group">
                                        <label for="old_keywords">Старое значение keywords</label>
                                        <input type="text" name="old_keywords" class="form-control"
                                               style="background-color: #e8b0b0;" value="{{ $data->old_keywords }}"
                                               disabled>
                                    </div>
                                    <div class="form-group mb-5">
                                        <label for="new_keywords">Новое значение keywords</label>
                                        <input type="text" name="new_keywords" class="form-control"
                                               style="background-color: #c6f5d0" value="{{ $data->new_keywords }}"
                                               disabled>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="email_update">Кто обновил</label>
                                    <input type="text" name="email_update" class="form-control"
                                           value="{{ AppView::getUserNameByEmail((string)$data->email) }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="updated_at">Дата обновления</label>
                                    <input type="text" name="updated_at" class="form-control"
                                           value="{{ $data->updated_at }}" disabled>
                                </div>
                                <a href="{{ route('seo.history.common', [$data->domain_id]) }}"
                                   class="btn btn-info mr-1" title=""><i class="fas fa-reply">&nbsp;&nbsp;</i>Вернуться
                                    назад</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
