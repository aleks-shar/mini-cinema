@extends('admin::layouts.admin')

@section('title', 'All users')

@section('h1', 'List of users')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('user.create') }}" class="btn btn-success mb-3">Добавить пользователя</a>
                    <a href="{{ route('admin.user.sessions') }}" class="btn btn-info ml-3 mb-3">Sessions</a>
                    <div class="card">
                        <div class="card-body p-0">
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            <form action="{{ route('admin.user.block', [$user->id]) }}"
                                                  method="post" style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn @if($user->is_active === 1) btn-danger @else btn-success @endif">
                                                    @if($user->is_active === 1)
                                                        Заблокировать
                                                    @else
                                                        Разблокировать
                                                    @endif
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <a class="btn btn-info" title="Edit user"
                                               href="{{ route('user.edit', $user->id) }}">Правка</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="post"
                                                  style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button title="Delete user" type="submit"
                                                        class="btn btn-danger delete-btn">Удаление
                                                </button>
                                            </form>
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
@endsection
