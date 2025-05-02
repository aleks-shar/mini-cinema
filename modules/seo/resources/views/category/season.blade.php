@extends('admin::layouts.admin')

@section('title', 'Задать индивидуальные мета-теги для сезона')

@section('h1', 'Задать индивидуальные мета-теги для сезона')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Название сезона</label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="Input Season name"
                                       value="@if(isset($title)){{$title}}@endif">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if($data)
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table table-striped projects">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Название сезона</th>
                                        <th>Сезон</th>
                                        <th>Кол-во серий</th>
                                        <th>Дата выхода</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $item)
                                        @if($item->meta->abuse || $item->meta->is_abuse)
                                            @continue
                                        @endif
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->part }}</td>
                                            <td>{{ $item->parts }}</td>
                                            <td>{{ $item->release_date }}</td>
                                            <td class="project-actions text-right">
                                                <a class="btn btn-primary"
                                                   href="{{ route('seo.individual.edit', ['season', (string)$item->slug, $item->id]) }}"
                                                   title="SEO">Задать теги</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
