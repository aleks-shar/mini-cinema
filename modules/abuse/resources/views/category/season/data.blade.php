@if($data)
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
                                    <th>Название</th>
                                    <th>Сезон</th>
                                    <th>Кол-во серий</th>
                                    <th>Дата выхода</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $item)
                                    @if($item->is_abuse !== 0)
                                        @continue
                                    @endif
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td><{{ $item->title }}</td>
                                        <td>{{ $item->part }}</td>
                                        <td>{{ $item->parts }}</td>
                                        <td>{{ $item->release_date }}</td>
                                        <td>
                                            <form
                                                action="{{ route('abuse.abuse', [$item->id, 'season']) }}"
                                                method="post" style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button title="Abuse" type="submit" class="btn btn-danger">
                                                    Заблокировать
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
@endif
