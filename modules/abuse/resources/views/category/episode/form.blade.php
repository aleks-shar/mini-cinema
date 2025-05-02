<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Название эпизода</label>
                            <input type="text" name="title" class="form-control"
                                   placeholder="Input title of a separate episode of the series"
                                   value="@if(isset($title)){{$title}}@endif">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
