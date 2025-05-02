@use(App\Admin\Common\Facades\AppView)

@if($data->total() > 0)
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Тип</th>
                                    <th>Сезон</th>
                                    <th>Эпизод</th>
                                    <th>Abuse?</th>
                                    <th>Обновил</th>
                                    <th>Дата изменения</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>{{ $item->season }}</td>
                                        <td>{{ $item->episode }}</td>
                                        <td>{{ $item->abuse }}</td>
                                        <td>{{ AppView::getUserNameByEmail($item->email) }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </section>
@endif
