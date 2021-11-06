$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    view_table();

    $('#cmb_iconos').select2();

    $("#btn_guardar").click(function () {

        id_pregunta = $('#hide_id').val();
        texto_pregunta = $('#texto_pregunta').val();
        sl_grupo = $('#sl_grupo option:selected').val();
        var sl_nivelprimario = $('#sl_nivelprimario option:selected').val();
        sl_subgrupo = $('#sl_subgrupo option:selected').val();
        num_respuesta = $('#num_respuesta').val();
        estado = ($('#chk_estado').prop('checked')) ? 'A' : 'I';

        var num = 1, lst_resp = "", num_mal = 0, lstRespuestas = '';

        var opcion = $('#sl_subgrupo option:selected').data('opcion');
        if (opcion == 'M') {
            var cmb_respuesta = $('input.cmb_respuesta').length;
            if (cmb_respuesta <= 0) {
                toastr.error('Error: Debe ingresar al menos una respuesta');
                return false;
            }

            $(".div_respuesta").each(function (i, obj) {
                var resp = $('#cmb_respuesta_' + num).val();
                if (resp <= 0) {
                    toastr.error('Error: Debe ingresar un valor para la Respuesta N° ' + num);
                    num_mal++;
                } else {
                    lst_resp = lst_resp + resp + ',';
                }
                num++;

            });

            lstRespuestas = lst_resp.slice(0, -1);

            if (num_mal > 0) {
                return false;
            }
        }

        if ($.trim(texto_pregunta) == '' || $.trim(sl_grupo) == '' || $.trim(sl_subgrupo) == '' || $.trim(num_respuesta) == '' || $.trim(sl_nivelprimario) == '') {
            toastr.error('Error: Por favor complete los campos');
            return false;
        }

        var data = $('#form').serialize();

        $.ajax({
            type: 'POST',
            url: '/save_pregunta',
            data: {
                hide_id: id_pregunta,
                texto_pregunta: texto_pregunta,
                grupo: sl_grupo,
                sl_nivelprimario: sl_nivelprimario,
                tipo: sl_subgrupo,
                estado: estado,
                lst_resp: lstRespuestas,
            },
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


    $("#chk_princ").click(function () {
        $('#div_secu').addClass('d-none');
        if ($("#chk_princ").is(':checked')) {
            $('#div_prin').removeClass('d-none');
        } else {
            $('#div_prin').addClass('d-none');
        }
    });

    $("#chk_secun").click(function () {
        $('#div_prin').addClass('d-none');
        if ($("#chk_secun").is(':checked')) {
            $('#div_secu').removeClass('d-none');
        } else {
            $('#div_secu').addClass('d-none');
        }
    });

});


function validar_respuesta() {
    var opcion = $('#sl_subgrupo option:selected').data('opcion');
    if (opcion == 'M') {
        $('#div_multiple').removeClass('d-none');
    }
    if (opcion == 'S') {
        $('#div_multiple').addClass('d-none');
    }
}


function ver_respuesta() {
    var num_comp = $('#num_respuesta').val();
    var num_ant = $('input.cmb_respuesta').length;
    var ini = parseInt(num_comp) + 1;

    for (var j = ini; j <= num_ant; j++) {
        $('#div_respuesta_' + j).remove();
    }
    for (var i = 1; i <= num_comp; i++) {
        var div_resp = "";
        div_resp = div_resp + '<div class="form-group row div_respuesta" id="div_respuesta_' + i + '"><label id="lbl_respuesta_' + i + '" class="col-sm-2 control-label">Respuesta N° ' + i + '</label>';
        div_resp = div_resp + '<div class="col-sm-8" id="div_sub_respuesta' + i + '"><input id=cmb_respuesta_' + i + ' class="form-control cmb_respuesta"/></div>';
        if ($("#cmb_respuesta_" + i).length > 0) {

        } else {
            $('#div_respuesta').append(div_resp);
        }
    }
}


function view_table() {
    var data = $('#form').serialize();
    $.ajax({
        type: 'POST',
        url: '/view_data_pregunta',
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
    $('#texto_pregunta').val('');
    $("#sl_grupo").val('').trigger('change');
    $('#sl_nivelprimario').val('');
    $("#sl_subgrupo").val('');
    $('#hide_id').val('');
    $('#num_respuesta').val(1);
    $('#num_respuestas_resp').val("");
    $('#chk_estado').prop('checked', true);
    $('#div_multiple').addClass('d-none');
    $('.div_respuesta').remove();

    var p = '<div class="form-group row div_respuesta" id="div_respuesta_1"><label id="lbl_respuesta_1" class="col-sm-2 control-label">Respuesta N° 1' +
        '</label> <div class="col-sm-8"> <input id="cmb_respuesta_1" class="form-control cmb_respuesta"></div></div>';

    $('#div_respuesta').append(p);

}

function editar(cod) {
    var data = cod;
    $.ajax({
        type: 'POST',
        url: '/edit_pregunta',
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
                $('#txt_nombre').val(d['data']['texto']);
                $('#hide_id').val(d['data']['id']);

                $('#texto_pregunta').val(d['data']['texto']);
                $('#sl_grupo').val(d['data']['tipo_encuesta_id']);
                $('#sl_nivelprimario').val(d['data']['nivel_primario_id']);
                $('#sl_subgrupo').val(d['data']['tipo_campo']);

                var respuestas = d['data']['respuestas'];

                if (respuestas != null) {
                    var res = respuestas.split(",");

                    $('#num_respuesta').val(res.length);
                    $('#num_respuestas_resp').val(res.length);

                    var num_ant = 2;

                    for (var j = 1; j <= num_ant; j++) {
                        $('#div_respuesta_' + j).remove();
                    }
                    var div_resp = "";
                    for (x = 0; x < res.length; x++) {

                        div_resp = div_resp + '<div class="form-group row div_respuesta" id="div_respuesta_' + (x + 1) + '"><label id="lbl_respuesta_' + (x + 1) + '" class="col-sm-2 control-label">Respuesta N° ' + (x + 1) + '</label>';
                        div_resp = div_resp + '<div class="col-sm-8" id="div_sub_respuesta' + (x + 1) + '"><input id=cmb_respuesta_' + (x + 1) + ' class="form-control cmb_respuesta" value="' + res[x] + '"/></div></div>';

                    }
                    $('#div_respuesta').append(div_resp);
                }

                var opcion = $('#sl_subgrupo option:selected').data('opcion');
                if (opcion == 'M') {

                    $('#div_multiple').removeClass('d-none');
                }
                if (opcion == 'S') {
                    $('#div_multiple').addClass('d-none');
                }
                var est = (d['data']['estado'] == 'A' ? true : false);
                $("#chk_estado").prop('checked', est);
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
                    url: '/delete_pregunta',
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

