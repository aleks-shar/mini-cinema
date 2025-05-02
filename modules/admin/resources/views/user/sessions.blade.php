@use(App\Admin\Common\Facades\AppView)

@extends('admin::layouts.admin')

@section('title', 'User\'s session')

@section('h1', 'User\'s session')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('admin.user.sessions.destroy.all') }}" method="post"
                          style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger mb-3 ml-3" type="submit">
                            Удалить все сессии
                        </button>
                    </form>
                    <div class="card">
                        <div class="card-body p-0">
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>IP</th>
                                    <th>Last Active</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>@if($item->user_id)
                                                {{ AppView::getUserNameById($item->user_id) }}
                                            @endif </td>
                                        <td>@if($item->user_id)
                                                {{ AppView::getUserEmailById($item->user_id) }}
                                            @endif </td>
                                        <td>{{ $item->ip_address }}</td>
                                        <td>{{ date('m/d/Y H:i:s', $item->last_activity) }}</td>
                                        <td>
                                            <form action="{{ route('admin.user.sessions.destroy', [$item->id]) }}"
                                                  method="post" style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger delete-btn"><i
                                                            class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
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
