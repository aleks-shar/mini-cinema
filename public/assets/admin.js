$(document).ready(function () {
    $(".nav-treeview .nav-link, .nav-link").each(function () {
        var location2 = window.location.protocol + '//' + window.location.host + window.location.pathname;
        var link = this.href;
        if (link == location2) {
            $(this).addClass('active');
            $(this).parent().parent().parent().addClass('menu-is-opening menu-open');
        }
    });

    $('.delete-btn').click(function () {
        var res = confirm('Подтвердите действия');
        if (!res) {
            return false;
        }
    });

    // summernote
    $('#summernote').summernote({
        tabsize: 2,
        height: 500,
        callbacks: {
            onImageUpload: function (image) {
                uploadImage(image[0]);
            }
        }
    });

    $(function () {
        $('input[name="daterange"]').daterangepicker({
            opens: 'right',
            //startDate: moment().startOf('day'),
            //endDate: moment().startOf('day'),
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
})
