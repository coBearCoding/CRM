$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $

    var c = 0;

    view_table();

    $("#btn_guardar").click(function () {

        var id = $('#hide_id').val();
        var name = $('#name').val();
        var email = $('#email').val();
        var idrol = $('#idrol').val();
        var idempresa = $('#idempresa').val();
        var password = $('#password').val();
        var password_conf = $('#password_confirmation').val();
        var extencion = $('#extencion').val();
        var llamada = $('#llamada').val();
        var idsede = $('#idsede').val();

        var chk_estado = 'off';
        if ($('#chk_estado').prop('checked')) {
            chk_estado = 'on';
        }

        var nivel_p = [];
        var nivel_v = [];
        var telefono = $('#telefono').val();
        var celular = $('#celular').val();

        c = 0;

        $('.np_cod').each(function () {
            s = $(this).val();
            if ($(this).prop('checked')) {
                nivel_p.push($('#np_' + s).val());
                if ($('#vend_' + s).prop('checked')) {
                    nivel_v.push($('#vend_' + s).val());
                } else {
                    nivel_v.push(0);
                }
                c++;
            }
        });

        if (c == 0) {
            toastr.error('Seleccione ' + nivelprimario);
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/register',
            data: {
                'hide_id': id,
                'name': name,
                'email': email,
                'idrol': idrol,
                'idempresa': idempresa,
                'password': password,
                'password_confirmed': password_conf,
                'extencion': extencion,
                'llamada': llamada,
                'idsede': idsede,
                'nivel_p': JSON.stringify(nivel_p),
                'nivel_v': JSON.stringify(nivel_v),
                'chk_estado': chk_estado,
                'telefono': telefono,
                'celular': celular
            },
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
            },
            success: function (data) {
                var d = JSON.parse(data);
                $('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                    view_table();
                    clear_data();
                }
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: ' + xhr.statusText + xhr.responseText);
            },
            complete: function () {
                $('#div_mensajes').addClass('d-none');
            },
            dataType: 'html'
        });
    });


    $(".btn_cancelar").click(function () {
        clear_data()
    });

    $(".np_cod").click(function () {
        var v = $(this).val();
        $('#vend_' + v).prop('checked', false);

        if ($('#np_' + v).prop('checked')) {
            $('#vend_' + v).prop('disabled', false);
        } else {
            $('#vend_' + v).prop('disabled', true);
        }
    });


});

function view_table() {
    var data = $('#form').serialize();
    $.ajax({
        type: 'POST',
        url: '/view_data_usuarios',
        data: data,
        beforeSend: function () {
            $('#div_mensajes').removeClass('d-none');
            $('#div_mensajes').addClass('text-center');
            $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
        },
        success: function (data) {
            $('#div_table').html(data);
            $('#tbl_users').DataTable({
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                },
                "paging": true,
                "lengthChange": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
            //acciones();

        },
        error: function (xhr) { // if error occured
            toastr.error('Error: ' + xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
        dataType: 'html'
    });
}

function Editar(data) {
    $.ajax({
            type: 'POST',
            url: '/edit_user',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": data
            },
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
            },
            success: function (d) {
                console.log(d['data']);
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['info']);
                    clear_data();
                    $("#custom-tabs-one-profile-tab").removeClass('active');
                    $("#custom-tabs-one-home-tab").addClass('active');

                    $("#custom-tabs-one-profile").removeClass('show active');
                    $("#custom-tabs-one-home").addClass('show active');
                    $('#name').val(d['data']['name']);
                    $('#email').val(d['data']['email']);
                    $('#idrol').val(d['data']['rol_id']);
                    $('#idempresa').val(d['data']['profile']['empresa_id']);
                    $('#hide_id').val(d['data']['id']);
                    $('#extencion').val(d['data']['profile']['extension']);
                    $('#llamada').val(d['data']['profile']['numero_llamada']);
                    $('#idsede').val(d['data']['profile']['sede_id']);
                    var est = (d['data']['status'] == 'A' ? true : false);
                    $("#chk_estado").prop('checked', est);
                    $('#telefono').val(d['data']['profile']['telefono']);
                    $('#celular').val(d['data']['profile']['celular']);

                    c = 0;

                    $('.np_cod').each(function () {
                        s = $(this).val();
                        $('#np_' + s).prop('checked', false);
                        $('#vend_' + s).prop('checked', false);
                    });

                    var permiso = d['data']['permiso_np'];

                    for (var i = 0; i < permiso.length; i++) {
                        $('#np_' + permiso[i]['nprimario_id']).prop('checked', true);
                        $('#vend_' + permiso[i]['nprimario_id']).prop('disabled', false);

                        if (permiso[i]['asesor_nprimario'] == "SI") {
                            $('#vend_' + permiso[i]['nprimario_id']).prop('checked', true);
                        } else {
                            $('#vend_' + permiso[i]['nprimario_id']).prop('checked', false);
                        }
                    }

                }
            },
            error:

                function (xhr) {
                    toastr.error('Error: '.xhr.statusText + xhr.responseText);
                }

            ,
            complete: function () {
                $('#div_mensajes').addClass('d-none');
            }
            ,
        }
    )
    ;
}

function clear_data() {
    $('#hide_id').val('');
    $('#idrol').val('');
    $('#name').val('');
    $('#email').val('');
    $('#password').val('');
    $('#password_confirmation').val('');
    $('#idempresa').val('');
    $('#extencion').val('');
    $('#llamada').val('');
    $('#idsede').val('');
    $('#chk_estado').val('');
    $('#celular').val('');
    $('#telefono').val('');

    $('#custom-tabs-one-home-tab').click();
    +
        $('.np_cod').each(function () {
            s = $(this).val();
            $('#np_' + s).prop('checked', false);
            $('#vend_' + s).prop('checked', false);
            $('#vend_' + s).prop('disabled', true);
        });
}

function eliminar(data) {
    $.confirm({
        title: 'Eliminar Uusario!',
        content: 'Desea realizar la eliminación del usuario ?',
        buttons: {
            confirm: function () {
                $.ajax({
                    type: 'POST',
                    url: '/delete_user',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "id": data
                    },
                    beforeSend: function () {
                        $('#div_mensajes').removeClass('d-none');
                        $('#div_mensajes').addClass('text-center');
                        $('#mensajes').html('<img src="../storage/images/load.gif" width="5%" height="5%" />');
                    },
                    success: function (d) {
                        if (d['msg'] == 'error') {
                            toastr.error(d['data']);
                        } else {
                            toastr.success(d['data']);
                            view_table();
                            clear_data();
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Error: '.xhr.statusText + xhr.responseText);
                    },
                    complete: function () {
                        $('#div_mensajes').addClass('d-none');
                    },
                });
            },
            cancel: function () {
                $.alert('Se ha cancelado la eliminación!');
            }
        }
    });
}

