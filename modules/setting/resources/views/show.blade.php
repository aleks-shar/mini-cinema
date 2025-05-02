@use(App\Admin\Common\Facades\AppView)
@use(Illuminate\Support\Str)

@extends('admin::layouts.admin')

@section('title', 'Настройки для сайта')

@section('h1', 'Настройки для сайта')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-danger mb-3"
                       href="{{ route('settings.history') }}"><i
                            class="fas fa-book-reader">&nbsp;&nbsp;</i>История</a>
                    <a href="{{ route('settings.create') }}" class="btn btn-primary mb-3 ml-3">Создать параметр</a>
                    <div class="card">
                        <div class="card-body p-0">
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <th>Параметр</th>
                                    <th>Значение</th>
                                    <th>Изменен</th>
                                    <th>Дата изменения</th>
                                    <th></th>
                                    @if(auth()->guard('admin')->user()->role === 'admin')
                                        <th></th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->key }}</td>
                                        <td title="{{ $item->value }}">{{ Str::limit($item->value, 30) }}</td>
                                        <td>{{ AppView::getUserNameByEmail((string)$item->email_update) }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            @if(! $item->is_file)
                                                <a class="btn btn-primary"
                                                   href="{{ route('settings.edit', [$item->id]) }}"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                            @endif
                                        </td>
                                        @if(auth()->guard('admin')->user()->role === 'admin')
                                            <td>
                                                @if($item->is_file)
                                                    <form
                                                        action="#"
                                                        method="post" style="display: inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-danger delete-btn"><i
                                                                class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form
                                                        action="{{ route('settings.destroy', [$item->id]) }}"
                                                        method="post" style="display: inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-danger delete-btn"><i
                                                                class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
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
