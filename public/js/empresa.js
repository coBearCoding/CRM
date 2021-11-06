$(document).ready(function()
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#btn_guardar").click(function(){

        var data = $('#form').serialize();

        $.ajax({
            type: 'POST',
            url: '/save_empresa',
            data: data,
            beforeSend: function() {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
            },
            success: function(data) {
                var d = JSON.parse(data);
                $('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                }
            },
            error: function(xhr) { // if error occured
                toastr.error('Error: '.xhr.statusText + xhr.responseText);
            },
            complete: function() {
                $('#div_mensajes').addClass('d-none');
            },
            dataType: 'html'
        });
    });

});

