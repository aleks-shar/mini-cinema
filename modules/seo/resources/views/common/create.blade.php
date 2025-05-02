@extends('admin::layouts.admin')

@section('title', 'Create')

@section('h1')
    Create tag
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <form action="{{ route('seo.store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="alias">Alias (*)</label>
                                    <input type="text" name="alias" class="form-control" placeholder="Input alias">
                                </div>
                                <div class="form-group">
                                    <label for="h1">H1</label>
                                    <input type="text" name="h1" class="form-control" placeholder="Input H1">
                                </div>
                                <div class="form-group">
                                    <label for="title">Title (*)</label>
                                    <input type="text" name="title" class="form-control" placeholder="Input title">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description (*)</label>
                                    <input type="text" name="description" class="form-control"
                                           placeholder="Input description">
                                </div>
                                <div class="form-group">
                                    <label for="keywords">Keywords</label>
                                    <input type="text" name="keywords" class="form-control"
                                           placeholder="Input keywords">
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
