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
                    <form action="{{ route('seo.history.common') }}" method="get">
                        @csrf
                        <div class="d-inline-flex">
                            <div class="form-group">
                                <label for="alias">Alias</label>
                                <select name="alias" class="form-control">
                                    <option value="" @if(request()->query('alias')=== null)selected @endif>----------
                                    </option>
                                    @foreach($aliases as $alias)
                                        <option value="{{ $alias['alias'] }}"
                                                @if(request()->query('alias')=== $alias['alias'])selected @endif>{{ $alias['alias'] }}</option>
                                    @endforeach
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
                                <label for="daterange">Date range:</label>
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
    @if($data->count() > 0)
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
                                        <th>TAG ID</th>
                                        <th>Alias</th>
                                        <th>Operation</th>
                                        <th>Кто обновил</th>
                                        <th>Дата обновления</th>
                                        <th>Действие</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->tag_id }}</td>
                                            <td>{{ $item->alias }}</td>
                                            <td>{{ $item->operation }}</td>
                                            <td>{{ AppView::getUserNameByEmail((string)$item->email) }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                            <td>
                                                <a href="{{ route('seo.history.common.id', [$item->id]) }}"
                                                   class="btn btn-info" title=""><i
                                                            class="fas fa-share">&nbsp;&nbsp;</i>Подробнее</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ $data->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
