@use(App\Admin\Common\Enums\RoleType)

@extends('admin::layouts.admin')

@section('title', 'Edit user')

@section('h1')
    Edit user {{ $user->name }}  :  {{ $user->email }}
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <form action="{{ route('user.update', $user->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Input name"
                                           value="{{ $user->name  }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" class="form-control" placeholder="Input Email"
                                           value="{{ $user->email }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control"
                                           placeholder="Input password">
                                </div>
                                <div class="form-group">
                                    <label for="role">Choose user\'s role'</label>
                                    <select name="role" class="form-control">
                                        <option value="seo"
                                                @if($user->role === 'seo')selected @endif>{{RoleType::SEO}}</option>
                                        <option value="admin"
                                                @if($user->role === 'admin')selected @endif>{{RoleType::ADMIN}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
