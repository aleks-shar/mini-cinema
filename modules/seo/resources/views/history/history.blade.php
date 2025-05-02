@use(App\Admin\Common\Facades\AppView)

@extends('admin::layouts.admin')

@section('title', 'History')

@section('h1', 'History')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('individual-history') }}" method="get">
                        @csrf
                        <div class="d-inline-flex">
                            <div class="form-group">
                                <label for="type">Тип</label>
                                <select name="type" class="form-control">
                                    <option value="" @if(request()->query('type')=== null)selected @endif>----------
                                    </option>
                                    <option value="movie" @if($type === 'movie')  selected @endif>movie</option>
                                    <option value="series" @if($type === 'series')  selected @endif>series</option>
                                    <option value="season" @if($type === 'season')  selected @endif>season</option>
                                    <option value="episode" @if($type === 'episode')  selected @endif>episode</option>
                                </select>
                            </div>
                            <div class="form-group ml-3">
                                <label for="title">Название</label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="Введите name для фильтрации"
                                       value="@if($title){{ $title }}@endif">
                            </div>
                            <div class="form-group ml-3">
                                <label for="action">Действие</label>
                                <select name="action" class="form-control">
                                    <option value="" @if(request()->query('action')=== null)selected @endif>----------
                                    </option>
                                    <option value="create" @if($action === 'create')  selected @endif>create</option>
                                    <option value="update" @if($action === 'update')  selected @endif>update</option>
                                    <option value="delete" @if($action === 'delete')  selected @endif>delete</option>
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
                                <label for="daterange">Дата:</label>
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
    @if($tags)
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table table-striped projects">
                                    <thead>
                                    <tr>
                                        <th>Тип</th>
                                        <th>Название</th>
                                        <th>Сезон</th>
                                        <th>Эпизод</th>
                                        <th>Действие</th>
                                        <th>Кто обновил</th>
                                        <th>Дата изменения</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tags as $item)
                                        <tr>
                                            <td>{{ $item->type }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->season }}</td>
                                            <td>{{ $item->episode }}</td>
                                            <td>{{ $item->action }}</td>
                                            <td>{{ AppView::getUserNameByEmail($item->email )}}</td>
                                            <td>{{ $item->updated_at }}</td>
                                            <td><a href="{{ route('individual-history-id', [$item->id]) }}"
                                                   class="btn btn-info" title="">Подробнее</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ $tags->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
