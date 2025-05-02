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
                                    <th>Год</th>
                                    <th>Directors</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $item)
                                    @if($item->meta->abuse || $item->meta->is_abuse)
                                        @continue
                                    @endif
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td><a href="{{ route('detailed.movie', [$item->id]) }}"
                                               target="_blank">{{ $item->title }}</a></td>
                                        <td>{{ $item->year }}</td>
                                        <td>{{ $item->directors }}</td>
                                        <td>
                                            @if($item->isOwnAbused())
                                                <a class="btn btn-primary"
                                                   href="{{ route('abuse.un-abuse', [$item->id, 'movie', $item->slug, $item->domain_id]) }}"
                                                   title="UnAbuse">Разблокировать</a>
                                            @endif
                                            @if(!$item->isOwnAbused())
                                                <form
                                                        action="{{ route('abuse.abuse', [$item->id, 'movie', $item->slug, $item->domain_id])}}"
                                                        method="POST" style="display: inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button title="Abuse" type="submit"
                                                            class="btn btn-danger">Заблокировать
                                                    </button>
                                                </form>
                                            @endif
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
