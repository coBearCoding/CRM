$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    view_table();
    $("#btn_guardar").click(function () {

        var cod = $('#rol option:selected').val();

        var roles = [];
        $("input:checkbox:checked").each(
            function () {
                roles.push($(this).val());
            }
        );

        if (cod == 0) {
            toastr.error('Seleccione rol.');
            return false;
        }

        if (roles.length == 0) {
            toastr.error('Seleccione permisos para el rol.');
            return false;
        }


        $.ajax({
            type: 'POST',
            url: '/save_permisos_rol',
            data: {rol: cod, lstRol: roles},
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
            },
            success: function (data) {
                var d = JSON.parse(data);
                $('#div_mensajes').removeClass('d-none text-center');
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                    view_table();
                }
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: '.xhr.statusText + xhr.responseText);
            },
            complete: function () {
                $('#div_mensajes').addClass('d-none');
            },
            dataType: 'html'
        });
    });
})


function view_table() {
    var data = $('#form').serialize();
    $.ajax({
        type: 'POST',
        url: '/view_data_permiso_rol',
        data: data,
        beforeSend: function () {
            $('#div_mensajes').removeClass('d-none');
            $('#div_mensajes').addClass('text-center');
            $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
        },
        success: function (data) {
            $('#div_table').html(data);
        },
        error: function (xhr) { // if error occured
            toastr.error('Error: '.xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
        dataType: 'html'
    });
}