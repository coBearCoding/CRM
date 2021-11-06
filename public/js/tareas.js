$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    
    //$("body").tooltip({ selector: '[data-toggle=tooltip]' });

    view_table();

    $("#btn_guardar").click(function () {

        var data = new $('#form').serialize();

        $.ajax({
            type: 'POST',
            url: '/register',
            data: data,
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
            },
            success: function (data) {
                //  $('#formregisterdiv').html(data);
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

    $("#oferta_academica").change(function(){
        $.ajax({
            type: 'POST',
            url: '/leads/programa/oferta',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'cod_programa':$(this).val()
            },
            success: function (data) {
                //  $('#formregisterdiv').html(data);
                var datos = JSON.parse(data);
                var option="";
                for (var i = 0; i < datos.length; i++) {
                    option += "<option value='"+datos[i].id+"'>"+datos[i].nombre+"</option>";
                }
                $("#programa").html('')
                $("#programa").append(option)
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

});

function view_table() {
    $("#tbl_tarea").DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":"/tareas/data",
        "columns":[
            {data:'nom_tarea'},
            {data:'det_tarea'},
            {data:'fecha_creacion'},
            {data:'fecha_vencimiento'},
            {data:'imp_tarea'},
            {data:'opciones'},
        ],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": true,
                "searchable": true
            },
            {
                "targets": [ 1 ],
                "visible": true,
                "searchable": true
            },
            {
                "targets": [ 2 ],
                "visible": true,
                "searchable": true
            },
            {
                "targets": [ 3 ],
                "visible": true,
                "searchable": true
            },
            {
                "targets": [ 4 ],
                "visible": true,
                "searchable": true
            },
            {
                "targets": [ 5 ],
                "visible": true,
                "searchable": true
            }
        ],
        "language": {
            "sProcessing": "<img src='../images/load.gif' width='100%' height='100%' />",
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
}

function setEmail(sl){
    $("#asunto").val($(sl).find(':selected').data('asunto'));
    console.log($(sl).find(':selected').data('html'))
    ck_plantilla.setData($(sl).find(':selected').data('html'));
}
function para(email){
    $("#para").val(email);
}




