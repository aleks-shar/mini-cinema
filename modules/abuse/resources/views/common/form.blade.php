@use(App\Admin\Common\Enums\ResourseType)

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <a href="{{ route('abuse.all') }}" class="btn btn-danger mb-3">Список заблокированных</a>
                <a href="{{ route('abuse.history') }}" class="btn btn-info mb-3 ml-3">История</a>
                <div class="card card-primary">

                    <form action="{{ route('abuse.common.title') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Название</label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="Input title"
                                       value="@if(isset($title)){{$title}}@endif">
                            </div>
                            <div class="form-group">
                                <label for="type2">Тип контента</label>
                                <select name="type2" class="form-control">
                                    <option value={{ ResourseType::MOVIE }}>{{ ResourseType::MOVIE }}</option>
                                    <option value={{ ResourseType::SERIES }}>{{ ResourseType::SERIES }}</option>
                                    <option value={{ ResourseType::SEASON }}>{{ ResourseType::SEASON }}</option>
                                    <option value={{ ResourseType::EPISODE }}>{{ ResourseType::EPISODE }}</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search">&nbsp;&nbsp;</i>Найти
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
