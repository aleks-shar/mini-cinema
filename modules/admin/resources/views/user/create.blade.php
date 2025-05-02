@use(App\Admin\Common\Enums\RoleType)

@extends('admin::layouts.admin')

@section('title', 'Create User')

@section('h1', 'Create User')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <form action="{{ route('user.store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Input name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" class="form-control" placeholder="Input Email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control"
                                           placeholder="Input password">
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">Password confirm</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                           placeholder="Input password again">
                                </div>
                                <div class="form-group">
                                    <label for="role">Choose User role</label>
                                    <select name="role" class="form-control">
                                        <option value="seo">{{ RoleType::SEO }}</option>
                                        <option value="admin">{{ RoleType::ADMIN }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
