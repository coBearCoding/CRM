$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    view_table();

    $('#cmb_iconos').select2();

    $("#btn_guardar").click(function () {

        var data = $('#form').serialize();

        $.ajax({
            type: 'POST',
            url: '/save_permisos',
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

function visual() {
    var logo = $('#cmb_iconos option:selected').data('logo');
    $('#n_icon').html('');
    $('#n_icon').html('<span class="icon-wrapper icon-wrapper-alt rounded-circle"><span class="icon-wrapper-bg" style="background-color:black"></span>\n' +
        '<i class="icon ' + logo + '" style="color:black"></i></span><p id="t_icon">' + logo + '</p>');
}


function view_table() {
    var data = $('#form').serialize();
    $.ajax({
        type: 'POST',
        url: '/view_data_permisos',
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
    $('#txt_nombre').val('');
    $('#txt_enlace').val('');
    $("#chk_estado").click();
    $('#hide_id').val('');
    $('#cmb_iconos').val('');
    $('#cmb_menu').val('');
    $('#txt_prefijo').val('');
    $('#chk_secun').prop('checked',false);
    $('#chk_princ').prop('checked',false);
    $('#div_secu').addClass('d-none');
    $('#div_prin').addClass('d-none');
}

function editar(cod) {
    var data = cod;
    $.ajax({
        type: 'POST',
        url: '/edit_permisos',
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
                $('#txt_nombre').val(d['data']['nombre']);
                $('#hide_id').val(d['data']['id']);

                if(d['data']['id_princ'] == null){
                    $('#div_prin').removeClass('d-none');
                    $('#chk_princ').prop('checked',true);
                    $('#chk_secun').prop('checked',false);
                    $('#txt_prefijo').val(d['data']['prefix']);
                    $('#cmb_iconos').val(d['data']['iconos']).trigger('change');
                }else{
                    $('#chk_princ').prop('checked',false);
                    $('#chk_secun').prop('checked',true);
                    $('#div_secu').removeClass('d-none');
                    $('#cmb_menu').val(d['data']['id_princ']).trigger('change');
                    $('#txt_enlace').val(d['data']['link']);
                    visual();
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
                    url: '/delete_permisos',
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

