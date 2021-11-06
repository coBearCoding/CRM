$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    view_table();

    $('#cmb_nprimario').select2();

    $("#btn_guardar").click(function () {

        var data = $('#form').serialize();

        $.ajax({
            type: 'POST',
            url: '/metas/save_metas',
            data: data,
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
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
                toastr.error('Error: '.xhr.statusText + xhr.responseText);
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

});


function view_table() {
    var data = $('#form').serialize();
    $.ajax({
        type: 'POST',
        url: '/metas/view_data_metas',
        data: data,
        beforeSend: function () {
            $('#div_mensajes').removeClass('d-none');
            $('#div_mensajes').addClass('text-center');
            $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
        },
        success: function (data) {
            $('#div_table').html(data);
            $('#tbl').DataTable({
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
                "ordering": false,
                "info": true,
                "autoWidth": false,
            });

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

function clear_data() {
    $('#custom-tabs-one-home-tab').click();
    $('#nombre').val('');
    $('#detalle').val('');
    $("#estado").click();
    $('#codigo_id').val('');
    $('#num_cliente').val('');
    $('#num_lead').val('');
    $('#sede_id').val('');
    $('#fch_inicio').val('');
    $('#fch_fin').val('');
    $('#nivel1_id').val('');

}

function editar(cod) {
    var data = cod;
    $.ajax({
        type: 'POST',
        url: '/metas/edit_metas',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id": data
        },
        beforeSend: function () {
            $('#div_mensajes').removeClass('d-none');
            $('#div_mensajes').addClass('text-center');
            $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
        },
        success: function (d) {
            if (d['msg'] == 'error') {
                toastr.error(d['data']);
            } else {
                $("#custom-tabs-one-profile-tab").removeClass('active');
                $("#custom-tabs-one-home-tab").addClass('active');

                $("#custom-tabs-one-profile").removeClass('show active');
                $("#custom-tabs-one-home").addClass('show active');
                toastr.success(d['info']);
                clear_data();
                $('#nombre').val(d['data']['nombre']);
                $('#detalle').val(d['data']['detalle']);
                $('#fch_inicio').val(d['data']['fecha_ini']);
                $('#fch_fin').val(d['data']['fecha_fin']);
                $('#num_lead').val(d['data']['num_lead']);
                $('#num_cliente').val(d['data']['num_cliente']);
                $('#sede_id').val(d['data']['sede_id']).trigger('change');
                $('#nivel1_id').val(d['data']['nprimario_id']).trigger('change');
                $('#codigo_id').val(d['data']['id']);
                d['data']['estado'] == 'A' ?  $("#estadoSi").prop('checked', true) :  $("#estadoNO").prop('checked', true);

            }
        },
        error: function (xhr) {
            toastr.error('Error: '.xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
    });
}

function eliminar(cod, name) {
    var data = cod;
    var name = name;
    $.confirm({
        title: 'Eliminar Información!',
        content: 'Desea realizar la eliminación de: ' + name + '?',
        buttons: {
            confirm: function () {
                $.ajax({
                    type: 'POST',
                    url: '/metas/delete_metas',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "id": data
                    },
                    beforeSend: function () {
                        $('#div_mensajes').removeClass('d-none');
                        $('#div_mensajes').addClass('text-center');
                        $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
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

