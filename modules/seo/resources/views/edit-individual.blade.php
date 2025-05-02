@use(App\Admin\Common\Facades\AppView)

@extends('admin::layouts.admin')

@section('title', 'Индивидуальные мета-теги')

@section('h1')
    Индивидуальные мета-теги для

    @if($category === 'movie')
        фильма
    @endif
    @if($category === 'series')
        сериала
    @endif
    @if($category === 'season')
        сезона
    @endif
    @if($category === 'episode')
        эпизода
    @endif
    @if($category === 'movie' || $category === 'series')
        <td>{{ $data->title }}</td>
    @endif
@endsection

@section('content')
    <section class="content" xmlns="http://www.w3.org/1999/html">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название
                                        @if($category === 'movie')
                                            фильма
                                        @endif
                                        @if($category === 'series' || $category === 'season' || $category === 'episode')
                                            сериала
                                        @endif
                                    </th>
                                    @if($category === 'movie' || $category === 'series')
                                        <th>Возраст+</th>
                                        <th>Год</th>
                                        <th>Режиссёр</th>
                                    @endif
                                    @if($category === 'season')
                                        <th>Сезон</th>
                                    @endif
                                    @if($category === 'episode')
                                        <th>Название эпизода</th>
                                        <th>Сезон</th>
                                        <th>Эпизод</th>
                                    @endif
                                    <th>Дата выхода</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    @if($category === 'movie' || $category === 'series' || $category === 'season')
                                        <td>{{ $data->title }}</td>
                                    @else
                                        <td>{{AppView::getSeriesTitleForEpisode((int)$data->id)}}</td>
                                    @endif
                                    @if($category === 'movie' || $category === 'series')
                                        <td>{{ $data->age_limit }}</td>
                                        <td>{{ $data->year }}</td>
                                        <td>{{ $data->directors }}</td>
                                    @endif
                                    @if($category === 'season')
                                        <td>{{ $data->part }}</td>
                                    @endif
                                    @if($category === 'episode')
                                        <td>{{ $data->title }}</td>
                                        <td>{{ AppView::getSeasonIdForEpisode((int)$data->season_id) }}</td>
                                        <td>{{ $data->part }}</td>
                                    @endif

                                    <td>{{ $data->release_date }}</td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <form action="{{ route('seo.individual.store', [$data->id, $category]) }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="h1">H1</label>
                                    <input type="text" name="h1" class="form-control" placeholder="Input H1"
                                           value="{{ $tags?->h1 }}">
                                    @if($apiTags && $apiTags['h1'])
                                        <span>{{ $apiTags['h1'] }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">Title (*)</label>
                                    <input type="text" name="title" class="form-control" placeholder="Input title"
                                           value="{{ $tags?->title }}">
                                    @if($apiTags && $apiTags['title'])
                                        <span>{{ $apiTags['title'] }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="description">Description (*)</label>
                                    <input type="text" name="description" class="form-control"
                                           placeholder="Input description" value="{{ $tags?->description }}">
                                    @if($apiTags && $apiTags['description'])
                                        <span>{{ $apiTags['description'] }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="keywords">Keywords</label>
                                    <input type="text" name="keywords" class="form-control" placeholder="Input keywords"
                                           value="{{ $tags?->keywords }}">
                                    @if($apiTags && $apiTags['keywords'])
                                        <span>{{ $apiTags['keywords'] }}</span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-success mr-3 mb-3"><i class="fas fa-save">&nbsp;&nbsp;</i>Сохранить
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
