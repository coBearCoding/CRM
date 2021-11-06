$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
    var start = moment();
    var end = moment();

    function cb(start, end) {
        $('#fecha span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $("#fecha_ini").val(start.format('YYYY-MM-DD'));
        $("#fecha_fin").val(end.format('YYYY-MM-DD'));
    }

    $("#estado").change(function(){
        $("#estado_export").val($(this).val())
    })



    $('#fecha').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Anterior Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    view_table();

    $("#btn_guardar").click(function(e){
    	e.preventDefault();
    	var data = new $('#formulario').serialize();
        $('#exampleModal').modal('toggle');
        $.ajax({
            type: 'POST',
            url: '/usuarios/register',
            data: data,
            beforeSend: function () {
                Swal.fire({
                    title: '¡Espere, Por favor!',
                    html: 'Cargando informacion...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });
            },
            success: function (data) {
                var d = JSON.parse(data);
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                    view_table();
                   // limpiar();
                }
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: '+xhr.statusText + xhr.responseText);
            },
            complete: function () {
               swal.close();
            },
            dataType: 'html'
        });
    });

     $("#actualizarEstado").click(function(e){

        e.preventDefault();

        if ($("#estado_edit").val()=="" || $("#estado_edit").val()==null) {
            return toastr.warning("Debe seleccionar un estado");
        }
        $('#estadoModal').modal('toggle');
        var data = $('#form_estado').serialize();

        $.ajax({
            type: 'POST',
            url: '/solicitudes/estado',
            data: data,
            beforeSend: function() {
                //
                Swal.fire({
                    title: '¡Espere, Por favor!',
                    html: 'Cargando informacion...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });
            },
            success: function(data) {
                //Swal.close();

                console.log(data)
                var d = JSON.parse(data);
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                   // view_table();
                    $("#tbl_solicitudes").DataTable().ajax.reload();
                   // clear_data();
                }
            },
            error: function(xhr) { // if error occured
                toastr.error('Error: '+xhr.statusText + xhr.responseText);
            },
            complete: function() {
                Swal.close();
            },
            dataType: 'html'
        });
    });
});
function busquedaTable(){
    $("#tbl_solicitudes").DataTable().ajax.reload();
}

function historial(id,codigo) {
    $('#title_historial').html("Solicitud N°"+codigo);
    $.ajax({
            type: 'POST',
            url: '/solicitudes/historial',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id_solicitud":id
            },
            beforeSend: function() {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
            },
            success: function(data) {
                $('#historial').html(data);
            },
            error: function(xhr) { // if error occured
                toastr.error('Error: '+xhr.statusText + xhr.responseText);
            },
            complete: function() {
                $('#div_mensajes').addClass('d-none');
            },
            dataType: 'html'
        });
}

function verDocumento(ruta,doc){
    $("#viewResult").html('');
    if (doc!='') {
        $("#viewResult").html('<embed src="'+ruta+doc+'" width="100%" height="100%" alt="pdf" >');
    }else{
        $("#viewResult").html('<p>No existe documento adjunto</p>');
    }
}


function documento(id,codigo) {
    $('#title_documento').html("Solicitud N°"+codigo);
    $.ajax({
            type: 'POST',
            url: '/solicitudes/documento',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id_solicitud":id
            },
            beforeSend: function() {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#documentos').html('<img src="../images/load.gif" width="10%" height="10%" />');
            },
            success: function(data) {
                $('#documentos').html(data);
                //console.log(data)

            },
            error: function(xhr) { // if error occured
                toastr.error('Error: '+xhr.statusText + xhr.responseText);
            },
            complete: function() {
                $('#div_mensajes').addClass('d-none');
            },
            dataType: 'html'
        });
}

function migrar(id,codigo,migrado) {
    if (migrado == "N") {
        $.confirm({
            title: "Migración de Postulante",
            content: '¿Desea inscribir al postulante en el sistema atrium?',
            buttons: {
                confirm: {
                    text: 'Inscribir',
                    btnClass:'btn-blue',
                    action:function () {
                        $.ajax({
                        type: 'POST',
                            url: '/solicitudes/migrar',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "solicitud_id":id
                            },
                        beforeSend: function () {
                            $('#div_mensajes_doc').removeClass('d-none');
                            $('#div_mensajes_doc').addClass('text-center');
                            $('#mensajes_doc').html('<img src="../images/load.gif" width="5%" height="5%" />');
                        },
                        success: function (d) {
                            console.log(d)
                             if (d['msg'] == 'error') {
                                toastr.error(d['data']);
                            } else {
                                toastr.success(d['data'])
                                $("#tbl_solicitudes").DataTable().ajax.reload(null,false);
                            }
                        },
                        error: function (xhr) {
                            toastr.error('Error: '+xhr.statusText + xhr.responseText);
                        },
                        complete: function () {
                            $('#div_mensajes_doc').addClass('d-none');
                        },
                    });
                 },
                },
                cancel: {
                    action:function () {
                        $.alert('Se ha cancelado la acción!');
                    },
                    text: 'Cerrar',
                }
            }
        });
    }else {
        $.alert({
            title: 'Información!',
            content: 'El postulante ya se encuentra registrado en el Atrium',
        });
    }

}



function aplicar_cambios(id,codigo,migrado){

    var id_solicitud = $("#idsolicitud").val();
    var cod_solicitud_documentos = $("#cod_solicitud_documentos").val();
    if(migrado == 'N'){
        $.confirm({
            title: 'Migración de Postulante',
            content: '¿Desea inscribir al postulante en el sistema atrium?',
            buttons:{
                confirm:{
                    text: 'Inscribir',
                    btnClass: 'btn-blue',
                    action: ()=>{
                        $.ajax({
                            type: 'POST',
                            url: '/solicitudes/aplicar-cambios',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "id_solicitud": $("#idsolicitud").val(),
                                "migrado": migrado,
                                "motivo": $('#motivo').val(),
                                "id":id_solicitud,
                                "migrar":'S'
                            },
                            beforeSend: function() {
                                $('#div_mensajes').removeClass('d-none');
                                $('#div_mensajes').addClass('text-center');
                                $('#documentos').html('<img src="../images/load.gif" width="10%" height="10%" />');
                            },
                            success: function(data) {
                                documento(id_solicitud,cod_solicitud_documentos);
                                busquedaTable()
                                console.log(data);
                            },
                            error: function(xhr) { // if error occured
                                toastr.error('Error: '+xhr.statusText + xhr.responseText);
                            },
                            complete: function() {
                                $('#div_mensajes').addClass('d-none');
                            },
                            dataType: 'html'
                        });
                    }
                },
                cancel:{
                    action: ()=>{
                        $.alert('Se ha cancelado la acción, Debera registrarlo manualmente!');
                        $.ajax({
                            type: 'POST',
                            url: '/solicitudes/aplicar-cambios',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "id_solicitud": $("#idsolicitud").val(),
                                "migrado": migrado,
                                "motivo": $('#motivo').val(),
                                "id":id_solicitud,
                                "migrar": 'N'
                            },
                            beforeSend: function() {
                                $('#div_mensajes').removeClass('d-none');
                                $('#div_mensajes').addClass('text-center');
                                $('#documentos').html('<img src="../images/load.gif" width="10%" height="10%" />');
                            },
                            success: function(data) {
                                documento(id_solicitud,cod_solicitud_documentos);
                                busquedaTable()
                                console.log(data);
                            },
                            error: function(xhr) { // if error occured
                                toastr.error('Error: '+xhr.statusText + xhr.responseText);
                            },
                            complete: function() {
                                $('#div_mensajes').addClass('d-none');
                            },
                            dataType: 'html'
                        });
                    },
                    text: 'Cerrar'
                }
            }
        })
    }else{
        $.alert({
            title: 'Información!',
            content: 'El postulante ya se encuentra registrado en el Atrium',
        });
    }


}

function aprobarDenegar(text,solicitud_documento_id,estado){
// debugger;
    var texto ="";
    var texto_aux ="";
    var btn ="";
    if (estado == 'A') {
        texto ="¡Aprobación!";
        texto_aux ="Aprobar";
        btn ="btn-blue";
    }else{
        texto ="¡Rechazar!";
        texto_aux ="Rechazar";
        btn ="btn-red";
    }
    if (solicitud_documento_id == 0) {
        return $.alert({
            title: '¡Alerta!',
            content: 'No se puede cambiar el estado actual, el postulante no posee ningún documento adjunto',
        });
    }
    var id_solicitud = $("#idsolicitud").val();
    var cod_solicitud_documentos = $("#cod_solicitud_documentos").val();
    $.confirm({
                title: texto,
                content: '¿Desea '+texto_aux+' '+text+'?',
                buttons: {
                    confirm: {
                        text: texto_aux,
                        btnClass:btn,
                        action:function () {
                            $.ajax({
                                type: 'POST',
                                url: '/solicitudes/aprobar-rechazar',
                                data: {
                                    "_token": $('meta[name="csrf-token"]').attr('content'),
                                    //"id": id_solicitud,
                                    "solicitud_documento_id":solicitud_documento_id,
                                    "estado":estado,
                                },
                                beforeSend: function () {
                                    $('#div_mensajes_doc').removeClass('d-none');
                                    $('#div_mensajes_doc').addClass('text-center');
                                    $('#mensajes_doc').html('<img src="../images/load.gif" width="5%" height="5%" />');
                                },
                                success: function (d) {
                                    console.log(d)
                                     if (d['msg'] == 'error') {
                                        toastr.error(d['data']);
                                    } else {
                                        toastr.success(d['data'])
                                        documento(id_solicitud,cod_solicitud_documentos);
                                        $("#tbl_solicitud").DataTable().ajax.reload();
                                    }


                                },
                                error: function (xhr) {
                                    toastr.error('Error: '+xhr.statusText + xhr.responseText);
                                },
                                complete: function () {
                                    $('#div_mensajes_doc').addClass('d-none');
                                },
                            });
                        },
                    },



                    cancel: {
                        action:function () {
                            $.alert('Se ha cancelado la acción!');
                        },
                        text: 'Cerrar',
                    }
                }
            });
}

function editar(id,name,email){
	console.log(12)
    //$('#EditModal').modal('toggle');
    $('#editModal').modal('toggle');
    $("#id").val(id);
    $("#nombre_edit").val(name);
    $("#correo_edit").val(email);
}

function estado(id,codigo){
    $("#id_solicitud").val(id);
}

function view_table(){
    $("#tbl_solicitudes").DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: '/solicitudes/data',
            method: 'POST',
            data: function (d) {
                d.estado = $('#estado').val() != "" ? $('#estado').val() : null;
                d.fecha_ini = $("#fecha_ini").val() + ' 00:00:00';
                d.fecha_fin = $("#fecha_fin").val() + ' 23:59:59';
            }
        },
        "columns":[
            {data: 'email'},
            {data:'nombres'},
            {data:'apellidos'},
            {data:'documento'},
            {data:'cod_solicitud'},
            /* Nombre de estado de solicitud */
            {data:'nombre'},
            /* DATOS DEL POSTULANTE */
            {render: function(data, type, full, meta){

                return (
                    '<b>Nombre:</b> '+full.nombres+' '+ full.apellidos + '<br>'+
                    '<b>Documento: </b> '+full.documento + '<br>'+
                    '<b>Email: </b> '+full.email + '<br>'+
                    '<b>Celular: </b> '+full.celular + '<br>'

                );
            }},
            /* DETALLE DE LA SOLICITUD */
            {render: function(data, type, full, meta){
                var text_cod_alum = '';
                if(full.codigo_alumno != null)
                    text_cod_alum = '<b>Codigo Alumno: </b>'+ full.codigo_alumno;
                return (
                    "<b># Solicitud: </b>" +full.cod_solicitud+ "<br>"+
                    "<b>Estado: </b>" +full.nombre+ "<br>"+
                    "<b>Asesor: </b>" +full.usuario_id+ "<br>"+
                    text_cod_alum
                );
            }},
            /*ESTADO DE PAGO */
            {render: function(data, type, full, meta){
                var text_pagado = '';
                if(full.cfac_pagado == 0){
                    text_pagado = 'Pendiente';
                }else if(full.cfac_pagado == 1){
                    text_pagado = 'Pagado';
                }

                return text_pagado;
            }},
            /* FECHA DE REGISTRO */
            {render: function(data, type, full, meta){
                var text_fecha =  moment(full.fecha_solicitud).format('YYYY-MM-DD HH:MM:SS');
                return text_fecha;
            }},
            /* Opciones */
            {render: function(data, type, full, meta){
                var button_migrar = '';
                var button_pdf = '';
                var migrado = 'N';
                if (full.cod_alum != null){
                    migrado = 'S';
                }
                if(full.estado_solicitud_id == 3){
                    button_migrar = `<button class="btn btn-outline-success  btn-sm"`+
                                    `title="Inscribir Estudiante" data-id="${full.solicitud_id}" data-toggle="tooltip" data-placement="top" `+
                                    ` onclick="migrar('${full.solicitud_id}','${full.cod_solicitud}', '${migrado}')">`+
                                    `<i class="fas fa-user-graduate"></i></button>`;
                }

                if(full.estado_id > 1){
                    button_pdf = `<a class="btn btn-outline-danger  btn-sm"`+
                    `title="Pdf" href="/solicitudes/pdf/${full.solicitud_id}/${full.cod_solicitud}">`+
                    `<i class="fas fa-file-pdf"></i></a>`;
                }


                return(
                    '<div>'+
                        `<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target=".modal-estado"`+
                            ` onclick="estado('${full.solicitud_id}', '${full.cod_solicitud}')"><i class="fas fa-edit"></i></button>`+

                        `<button class="btn btn-outline-success  btn-sm"`+
                                `title="Historial" data-id="${full.solicitud_id}" data-toggle="modal" data-target=".modal-historial" `+
                                ` onclick="historial('${full.solicitud_id}','${full.cod_solicitud}')">`+
                             `<i class="fas fa-align-center"></i></button>`+

                        `<button class="btn btn-outline-info  btn-sm"`+
                            `title="Documentos" data-id="${full.solicitud_id}" data-toggle="modal" data-target=".modal-documento" `+
                            ` onclick="documento('${full.solicitud_id}','${full.cod_solicitud}')">`+
                            `<i class="fas fa-file"></i></button>`+

                        button_pdf +
                        button_migrar +

                    '</div>'
                );
            }},

        ],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [ 2 ],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [ 3 ],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [ 4 ],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [ 5 ],
                "visible": false,
                "searchable": true //Hasta aqui false
            },
            {
                "targets": [ 6 ],
                "visible": true,
                "searchable": true
            },
            {
                "targets": [ 7 ],
                "visible": true,
                "searchable": true
            },
            {
                "targets": [ 8 ],
                "visible": true,
                "searchable": true
            }
            ,
            {
                "targets": [ 9 ],
                "visible": true,
                "searchable": false
            }
            ,
            {
                "targets": [ 10 ],
                "visible": true,
                "searchable": true
            },
        ],
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
                "sNext": "<i class='fas fa-angle-right'>",
                "sPrevious": "<i class='fas fa-angle-left'>"
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
        "searchable": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "order": [[ 10, "desc" ]]
    });

    $("#tbl_solicitudes_wrapper").find('div.row').first().addClass('p-4');
    $("#tbl_solicitudes_wrapper").find('div.row').last().addClass('p-4');
}
