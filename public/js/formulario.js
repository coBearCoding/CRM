$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    view_table();

 
    $('#cmb_campana').select2();


    $("#getJS").click(function () {
        var dataXml = $('.build-wrap').formBuilder("getData", "xml");
        showPreview(dataXml);

    });

    $("#btn_guardar").click(function () {

        var data = $('#form').serialize();

        $.ajax({
            type: 'POST',
            url: '/save_form',
            data: data,
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


    $('#cmb_campana').change(function () {

        var data = $(this).val();
        $.ajax({
            type: 'POST',
            url: '/view_form_n2',
            data: {id: data},
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
            },
            success: function (data) {
                $('#div_nivel2').html(data);

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


});


function view_table() {
    var data = $('#form').serialize();
    $.ajax({
        type: 'POST',
        url: '/view_data_form',
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
    $("#cmb_campana").val('');
    $('#hide_id').val('');
    var t = [];
    $(".build-wrap").formBuilder("setData", t)
}


function editData(id) {


    $.ajax({
        type: 'POST',
        url: '/edit_form',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id": id
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
                $(".build-wrap").formBuilder("clearFields");
                $("#custom-tabs-one-profile-tab").removeClass('active');
                $("#custom-tabs-one-home-tab").addClass('active');

                $("#custom-tabs-one-profile").removeClass('show active');
                $("#custom-tabs-one-home").addClass('show active');
                toastr.success(d['info']);
                clear_data();
                $('#nombre').val(d['data']['nombre']);
                $('#hide_id').val(d['data']['id']);
                $('#cmb_campana').val(d['data']['campana_id']).trigger('change');;
                var json = d['data']['json_texto'];
                var t = json;
                $(".build-wrap").formBuilder("setData", t);
                $("#form_render").click();
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

function showPreview(formData) {
    let formRenderOpts = {
        dataType: 'xml',
        formData
    };
    let $renderContainer = $('<form/>');
    $renderContainer.formRender(formRenderOpts);
    var est = $renderContainer.html();

    let html = '<!doctype html><title>Form Preview</title><body class="container"><h1>Vista Previa</h1><hr>' + est + '</body></html>';
    var formPreviewWindow = window.open('target', '_blank');
    formPreviewWindow.document.write(html);
    var style = document.createElement('link');
    style.setAttribute('href', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
    style.setAttribute('rel', 'stylesheet');
    style.setAttribute('type', 'text/css');
    formPreviewWindow.document.head.appendChild(style);
}

function eliminar(cod,name) {
    var data = cod;
    var name = name;
    $.confirm({
        title: 'Eliminar Información!',
        content: 'Desea realizar la eliminación de: ' + name + '?',
        buttons: {
            confirm: function () {
                $.ajax({
                    type: 'POST',
                    url: '/delete_formulario',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "id" : data
                    },
                    beforeSend: function() {
                        $('#div_mensajes').removeClass('d-none');
                        $('#div_mensajes').addClass('text-center');
                        $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
                    },
                    success: function(d) {
                        if (d['msg'] == 'error') {
                            toastr.error(d['data']);
                        } else {
                            toastr.success(d['data']);
                            view_table();
                           // clear_data();
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error: '.xhr.statusText + xhr.responseText);
                    },
                    complete: function() {
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
