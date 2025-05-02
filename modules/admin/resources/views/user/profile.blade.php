@extends('admin::layouts.admin')

@section('title', 'Профиль пользователя')

@section('h1', 'Профиль пользователя')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <form action="{{ route('user.profile_edit', $user->id) }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Имя</label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="role">Роль</label>
                                    <input type="text" name="role" class="form-control" value="{{ $user->role }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label for="theme">Выбрать тему</label>
                                    <select name="theme" class="form-control">
                                        <option value="light" @if($user->theme === 'light')selected @endif>Светлая
                                        </option>
                                        <option value="dark" @if($user->theme === 'dark')selected @endif>Темная</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="password">Пароль</label>
                                    <input type="password" name="password" class="form-control"
                                           placeholder="Input password">
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">Повторить пароль</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                           placeholder="Input password again">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Обновить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
