@use(App\Admin\Common\Facades\AppView)

@extends('admin::layouts.admin')

@section('title', 'История')

@section('h1', 'История')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('settings.history') }}" method="get">
                        @csrf
                        <div class="d-inline-flex">
                            <div class="form-group">
                                <label for="action">Action</label>
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
                                        <option value="{{ AppView::getUserNameByEmail($email['email'] )}}"
                                                @if(request()->query('email') === AppView::getUserNameByEmail($email['email']))selected @endif>{{ AppView::getUserNameByEmail($email['email']) }}</option>
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
                                    <th>Parameter ID</th>
                                    <th>Пользователь</th>
                                    <th>Действие</th>
                                    <th>Новое название</th>
                                    <th>Обновлено</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->tag_id }}</td>
                                        <td><strong>{{ AppView::getUserNameByEmail($item->email ) }}</strong></td>
                                        <td><strong>{{ $item->action  }}</strong></td>
                                        <td><strong>{{ $item->new_key }}</strong></td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('settings.history.show', [$item->id]) }}"
                                               class="btn btn-info" title=""><i
                                                        class="fas fa-share"></i></a></td>
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
@endsection
