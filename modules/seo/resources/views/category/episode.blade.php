@use(App\Admin\Common\Enums\DomainName)
@use(App\Admin\Common\Facades\AppView)

@extends('admin::layouts.admin')

@section('title', 'Задать индивидуальные мета-теги для эпизода')

@section('h1', 'Задать индивидуальные мета-теги для эпизода')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Название эпизода</label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="Input name for episode"
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
                                        <th>Название сериала</th>
                                        <th>Название эпизода</th>
                                        <th>Сезон</th>
                                        <th>Эпизод</th>
                                        <th>Дата выхода</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{AppView::getSeriesTitleForEpisode((int)$item->id)}}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{AppView::getSeasonIdForEpisode((int)$item->season_id)}}</td>
                                            <td>{{ $item->part }}</td>
                                            <td>{{ $item->release_date }}</td>
                                            <td class="project-actions text-right">
                                                <a class="btn btn-primary"
                                                   href="{{ route('seo.individual.edit', ['episode', (string)$item->slug, (int)$item->id]) }}"
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
