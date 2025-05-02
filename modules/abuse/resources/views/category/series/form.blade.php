<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Название сериала</label>
                            <input type="text" name="title" class="form-control"
                                   placeholder="Input Series title"
                                   value="@if(isset($title)){{$title}}@endif">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
