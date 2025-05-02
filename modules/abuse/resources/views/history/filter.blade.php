@use(App\Admin\Common\Enums\ResourseType)
@use(App\Admin\Common\Facades\AppView)
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('abuse.history') }}" method="get">
                    @csrf
                    <div class="d-inline-flex">
                        <div class="form-group">
                            <label for="type">Тип:</label>
                            <select name="type" class="form-control">
                                <option value="" @if(request()->query('type')=== null)selected @endif>------
                                </option>
                                <option value="{{ ResourseType::MOVIE->value }}"
                                        @if($type === ResourseType::MOVIE->value)  selected @endif>{{ ResourseType::MOVIE->value }}</option>
                                <option value="{{ ResourseType::SERIES->value }}"
                                        @if($type === ResourseType::SERIES->value)  selected @endif>{{ ResourseType::SERIES->value }}</option>
                                <option value="{{ ResourseType::SEASON->value }}"
                                        @if($type === ResourseType::SEASON->value)  selected @endif>{{ ResourseType::SEASON->value }}</option>
                                <option value="{{ ResourseType::EPISODE->value }}"
                                        @if($type === ResourseType::EPISODE->value)  selected @endif>{{ ResourseType::EPISODE->value }}</option>
                            </select>
                        </div>
                        <div class="form-group ml-3">
                            <label for="email">Email</label>
                            <select name="email" class="form-control">
                                <option value="" @if(request()->query('email')=== null)selected @endif>----------
                                </option>
                                @foreach($emails as $email)
                                    <option
                                        value="{{ AppView::getUserNameByEmail($email['email']) }}"
                                        @if(request()->query('email')=== AppView::getUserNameByEmail($email['email']))selected @endif>{{ AppView::getUserNameByEmail($email['email']) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ml-3">
                            <label for="title">Название</label>
                            <input type="text" name="title" class="form-control"
                                   placeholder="Введите название для фильтрации"
                                   value="@if($title){{ $title }}@endif">
                        </div>
                        <div class="form-group ml-3">
                            <label for="abuse">Abuse:</label>
                            <select name="abuse" class="form-control">
                                <option value="" @if(request()->query('abuse')=== null)selected @endif>--</option>
                                <option value="NO" @if($abuse === "NO")  selected @endif>Нет</option>
                                <option value="YES" @if($abuse === "YES")  selected @endif>Да</option>
                            </select>
                        </div>
                        <div class="form-group ml-3">
                            <label for="daterange"> Дата изменения:</label>
                            <input id="date" type="text" class="form-control" name="daterange"
                                   value="@if($daterange) {{ $daterange }} @endif"/>
                        </div>
                    </div>
                    <br/>
                    <button type="submit" class="btn btn-primary mb-3"><i
                            class="fas fa-search">&nbsp;&nbsp;</i>Фильтровать
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
