@use(App\Admin\Common\Facades\AppView)

@extends('admin::layouts.admin')

@section('title', 'Domain meta tag templates')

@section('h1')
    Domain meta tag templates
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-danger mb-3 mr-3" href="{{ route('seo.history.common') }}"><i
                                class="fas fa-book-reader">&nbsp;&nbsp;</i>История</a>
                    <a class="btn btn-success mb-3" href="{{ route('seo.create') }}">Создать</a>
                    <div class="card">
                        <div class="card-body p-0">
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <th>TAG ID</th>
                                    <th>Alias</th>
                                    <th>Кто обновил</th>
                                    <th>Когда обновил</th>
                                    <th></th>
                                    @if(Auth()->guard('admin')->user()->role === 'admin')
                                        <th></th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->alias }}</td>
                                        <td>{{ AppView::getUserNameByEmail((string)$item->email) }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td class="project-actions text-right">
                                            <a class="btn btn-primary"
                                               href="{{ route('seo.edit', [$item->id]) }}"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                        </td>
                                        @if(Auth()->guard('admin')->user()->role === 'admin')
                                            <td>
                                                <form
                                                        action="{{ route('seo.destroy', ['seoId' => $item->id]) }}"
                                                        method="post" style="display: inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger delete-btn"><i
                                                                class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        @endif
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
