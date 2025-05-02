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
                                    <th>Directors</th>
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
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->directors }}</td>
                                        <td>{{ $item->release_date }}</td>
                                        <td class="project-actions text-right">
                                            <form
                                                action="{{ route('abuse.abuse', [$item->id, 'series'])}}"
                                                method="post" style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button title="Abuse" type="submit"
                                                        class="btn btn-danger">Заблокировать
                                                </button>
                                            </form>
                                        </td>
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
