@use(App\Admin\Common\Facades\AppView)
@use(App\Admin\Common\Enums\ResourseType)

@extends('admin::layouts.admin')

@section('title', 'Список заблокированных ресурсов')

@section('h1', 'Список заблокированных ресурсов')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('abuse.all') }}" method="get" id="form">
                        @csrf
                        <div class="d-inline-flex">
                            <div class="form-group ml">
                                <label for="type">Тип:</label>
                                <select name="type" class="form-control">
                                    <option value="" @if(request()->query('type')=== null)selected @endif>------
                                    </option>
                                    <option value="{{ ResourseType::MOVIE->value }}"
                                            @if($type === ResourseType::MOVIE->value)  selected @endif>{{ ResourseType::MOVIE->value }}</option>
                                    <option value="{{ ResourseType::SERIES->value }}"
                                            @if($type === ResourseType::SERIES->value)  selected @endif>{{ ResourseType::SERIES->value }}</option>
                                    <option value="{{ ResourseType::SEASON->value }}"
                                            @if($type === ResourseType::SEASON->value)  selected @endif>{{ ResourseType::SEASON->value }}</option>
                                    <option value="{{ ResourseType::EPISODE->value }}"
                                            @if($type === ResourseType::EPISODE->value)  selected @endif>{{ ResourseType::EPISODE->value }}</option>
                                </select>
                            </div>
                            <div class="form-group ml-3">
                                <label for="email">Email</label>
                                <select name="email" class="form-control">
                                    <option value="" @if(request()->query('email')=== null)selected @endif>----------
                                    </option>
                                    @foreach($emails as $email)
                                        <option value="{{ AppView::getUserNameByEmail($email['email']) }}"
                                                @if(request()->query('email')=== AppView::getUserNameByEmail($email['email']))selected @endif>{{ AppView::getUserNameByEmail($email['email']) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group ml-3">
                                <label for="daterange"> Дата изменения:</label>
                                <input id="date" type="text" class="form-control" name="daterange"
                                       value="@if($daterange) {{ $daterange }} @endif"/>
                            </div>
                        </div>
                        <br/>
                        <button type="submit" class="btn btn-primary mb-3"><i
                                class="fas fa-search">&nbsp;&nbsp;</i>Фильтровать
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @if($abused->total() > 0)
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
                                        <th>Название</th>
                                        <th>Тип</th>
                                        <th>Сезон</th>
                                        <th>Эпизод</th>
                                        <th>Обновил</th>
                                        <th>Дата изменения</th>
                                        @if(auth()->guard('admin')->user()->role === 'admin')
                                            <th></th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($abused as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{AppView::getTitle($item->model_id, $item->category) }}
                                            </td>
                                            <td>{{ $item->category }}</td>
                                            <td>{{AppView::getSeason($item->model_id, $item->category) }}</td>
                                            <td>{{AppView::getEpisode($item->model_id, $item->category) }}</td>
                                            <td>{{ AppView::getUserNameByEmail($item->email)  }}</td>
                                            <td>{{ $item->updated_at  }}</td>
                                            @if(auth()->guard('admin')->user()->role === 'admin')
                                                <td class="project-actions text-right">
                                                    <a class="btn btn-primary"
                                                       href="{{ route('abuse.un-abuse', [(int)$item->model_id, $item->category]) }}">Разблокировать</a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ $abused->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
