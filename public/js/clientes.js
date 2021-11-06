var ck_plantilla;
var tbl_clientes;
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    ClassicEditor
        .create( document.querySelector( '#txt_plantilla' ) )
        .then( editor => {
               // console.log( editor );
                ck_plantilla=editor;
        } )
        .catch( error => {
                console.error( error );
        } );
    //$("body").tooltip({ selector: '[data-toggle=tooltip]' });

    var start = moment();
    var end = moment();

    function cb(start, end) {
        $('#fecha span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $("#fecha_ini").val(start.format('YYYY-MM-DD'));
        $("#fecha_fin").val(end.format('YYYY-MM-DD'));
    }



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

    $("#btn_estado_comercial").click(function () {
        if (!$("#formulario_estado").valid()) {
            return false;
        }
        var data = new $('#formulario_estado').serialize();

        $.ajax({
            type: 'POST',
            url: '/leads/estado',
            data: data,
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
            },
            success: function (data) {
                console.log(data);
                var d = JSON.parse(data);
                $('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                    $("#tbl_clientes").DataTable().ajax.reload();
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

    $("#btn_seguimiento").click(function () {
        if (!$("#formulario_seguimiento").valid()) {
            return false;
        }
        var data = new $('#formulario_seguimiento').serialize();

        $.ajax({
            type: 'POST',
            url: '/leads/seguimiento',
            data: data,
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
            },
            success: function (data) {
                console.log(data);
                var d = JSON.parse(data);
                $('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                    $("#tbl_clientes").DataTable().ajax.reload();
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

    $("#btn_enviar_mail").click(function () {
        if (!$("#formulario_envio").valid()) {
            return false;
        }
        var data = new $('#formulario_envio').serialize();

        $.ajax({
            type: 'POST',
            url: '/leads/transaccional',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'cc':$("#cc").val(),
                'cco':$("#cco").val(),
                'para':$("#para").val(),
                'asunto':$("#asunto").val(),
                'asunto':$("#asunto").val(),
                'template':ck_plantilla.getData(),
                'id':$("#transaccional_tipo_contacto_id").val()
            },
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
            },
            success: function (data) {
                console.log(data);
                var d = JSON.parse(data);
                $('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                    $("#tbl_clientes").DataTable().ajax.reload();
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

    $("#btn_enviar").click(function () {
        if (!$("#formulario").valid()) {
            return false;
        }
        var data = new $('#formulario').serialize();

        $.ajax({
            type: 'POST',
            url: '/leads/post',
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
                    $("#tbl_clientes").DataTable().ajax.reload();
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



    $.validator.addMethod('isMail', function(value, element, param) {
    if( /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test(value) ){
            // Hacer algo si el checkbox ha sido seleccionado
            return true;
        } else {
            // Hacer algo si el checkbox ha sido deseleccionado
            return false;
        }
    }, "Por favor, introduce una dirección de correo electrónico válida");


     $("#formulario").validate({
        ignore: [],
        rules: {
          'nombre'          : {required: true},
          'campana'            : {required: true},
          'oferta_academica'          : {required: true,},
          'programa'          : {required: true,},
          'email'          : {required: true,isMail:true},
          'fuente'          : {required: true},
        },
        messages:{
          'cedula':{
            minlength: "Por favor, ingresa {0} caracteres",
            maxlength: "Por favor, ingresa {0} caracteres",
          }
        },
          errorPlacement: function (error, element) {
            var er=error[0].innerHTML;
            var nombre = element[0].id;
            if(element[0].type=="select-one"){
                $("#" + nombre).parent().find(".select2-container").addClass("error");
            }else{
                $("#" + nombre).addClass("is-invalid");
            }
            $("#" + nombre + "-error").html(er);
            $("#" + nombre + "-error").show();
          }, unhighlight: function (element) {
            var nombre = element.id;
            if(element.type=="select-one"){
                $("#" + nombre).parent().find(".select2-container").removeClass("error");
            }else{
                $("#" + nombre).removeClass("is-invalid");
            }
            $("#" + nombre + "-error").hide();
            $("#"+nombre).removeClass("error");
          }
      });

       $("#formulario_estado").validate({
        ignore: [],
        rules: {
          'observacion_estado'          : {required: true},
          'estado_comercial_modal'            : {required: true},
        },
        messages:{
          'cedula':{
            minlength: "Por favor, ingresa {0} caracteres",
            maxlength: "Por favor, ingresa {0} caracteres",
          }
        },
          errorPlacement: function (error, element) {
            var er=error[0].innerHTML;
            var nombre = element[0].id;
            if(element[0].type=="select-one"){
                $("#" + nombre).parent().find(".select2-container").addClass("error");
            }else{
                $("#" + nombre).addClass("is-invalid");
            }
            $("#" + nombre + "-error").html(er);
            $("#" + nombre + "-error").show();
          }, unhighlight: function (element) {
            var nombre = element.id;
            if(element.type=="select-one"){
                $("#" + nombre).parent().find(".select2-container").removeClass("error");
            }else{
                $("#" + nombre).removeClass("is-invalid");
            }
            $("#" + nombre + "-error").hide();
            $("#"+nombre).removeClass("error");
          }
      });

       $("#formulario_seguimiento").validate({
        ignore: [],
        rules: {
          'seguimiento_modal'          : {required: true},
          'observacion_seguimiento'            : {required: true},
          'medio_gestion_seguimiento'            : {required: true},
        },
        messages:{
          'cedula':{
            minlength: "Por favor, ingresa {0} caracteres",
            maxlength: "Por favor, ingresa {0} caracteres",
          }
        },
          errorPlacement: function (error, element) {
            var er=error[0].innerHTML;
            var nombre = element[0].id;
            if(element[0].type=="select-one"){
                $("#" + nombre).parent().find(".select2-container").addClass("error");
            }else{
                $("#" + nombre).addClass("is-invalid");
            }
            $("#" + nombre + "-error").html(er);
            $("#" + nombre + "-error").show();
          }, unhighlight: function (element) {
            var nombre = element.id;
            if(element.type=="select-one"){
                $("#" + nombre).parent().find(".select2-container").removeClass("error");
            }else{
                $("#" + nombre).removeClass("is-invalid");
            }
            $("#" + nombre + "-error").hide();
            $("#"+nombre).removeClass("error");
          }
      });

    $(".btn_cancelar").click(function () {
        clear_data()
    });

    $("#campana").change(function(){
        $.ajax({
            type: 'POST',
            url: '/leads/campana/programa',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'id':$(this).val()
            },
            success: function (data) {
                var datos = JSON.parse(data);

                console.log(datos)
                //  $('#formregisterdiv').html(data);
                var option="";
                for (var i = 0; i < datos['programas'].length; i++) {
                    if (datos['programas'][i].programa != null) {
                        option += "<option value='"+datos['programas'][i].id+"'>"+datos['programas'][i].programa.nombre+"</option>";
                    }
                }
                $("#programa").html('')
                $("#programa").append(option)

                var optionvendedor="";
                for (var i = 0; i < datos['vendedores'].length; i++) {
                    if (datos['vendedores'][i].user != null) {
                        optionvendedor += "<option value='"+datos['vendedores'][i].user_id+"'>"+datos['vendedores'][i].user.name+"</option>";
                    }
                }
                console.log(optionvendedor)
                $("#vendedor").html('')
                $("#vendedor").append(optionvendedor)
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
   $("#tbl_clientes").DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: '/clientes/data',
             method: 'POST',
            data: function (d) {
                d.estado = $('#estado_search').val() != "" ? $('#estado_search').val() : null;
                 d.fuente = $('#fuente_search').val() != "" ? $('#fuente_search').val() : null;
                d.fecha_ini = $("#fecha_ini").val() + ' 00:00:00';
                d.fecha_fin = $("#fecha_fin").val() + ' 23:59:59';
            }
        },
        "columns":[
            {data:'opt'},
            {data:'created_at'},
            {data:'contacto.nombre'},
            {data:'contacto.correo'},
            {data:'datos'},
            {data:'detail'},
            //{data:'contacto_historico_last.vendedor.name'},
            {render: function ( data, type, full, meta ) {
                    return full.contacto_historico_last.vendedor != null ? full.contacto_historico_last.vendedor.name: 'Sin Gestionar';
                }
            },
            {data:'contacto_historico_last.estado_comercial.nombre'},
            {render: function ( data, type, full, meta ) {
                    return full.contacto_historico_last.fuente_contacto != null ? full.contacto_historico_last.fuente_contacto.nombre: 'Sin Gestionar';
                }
            },
            {data:'ingreso'},
            {data:'opciones'},
        ],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": true,
                "searchable": false
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
                "visible": true,
                "searchable": true
            },
            {
                "targets": [ 5 ],
                "visible": true,
                "searchable": true
            }
            ,
            {
                "targets": [ 6 ],
                "visible": true,
                "searchable": true
            }
            ,
            {
                "targets": [ 7 ],
                "visible": true,
                "searchable": false
            },
            {
                "targets": [ 8 ],
                "visible": true,
                "searchable": true
            },
            {
                "targets": [ 9 ],
                "visible": true,
                "searchable": true
            },
            {
                "targets": [ 10 ],
                "visible": true,
                "searchable": false
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
        "order": [[ 1, "desc" ]]
    });
}

function busqueda_search(){
    $("#tbl_clientes").DataTable().ajax.reload();
}
function abrir(botonimg, id) {
    //debugger;
    //let botonimg = opt.toElement;
    let row = $(botonimg).parents('tr')[0];
    var tbl = $('#tbl_clientes').dataTable();
    if (tbl.fnIsOpen(row)) {
      tbl.fnClose(row);
      botonimg.src = "/images/details_open.png";
    } else {
      $.ajax({
        type: 'POST',
        url: '/leads/historial',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id": id
        },
        beforeSend: function () {
            $('#div_mensajes').removeClass('d-none');
            $('#div_mensajes').addClass('text-center');
            $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
        },
        success: function (d) {
            console.log(d)
            var table = "<table class='table table-bordered' with='100%'><thead class='thead-light'><tr>"+
                        "<th>Fuente de Contacto</th>"+
                        "<th>Interes</th>"+
                        "<th>Estado Comercial</th>"+
                        "<th>Vendedor</th>"+
                        "<th>Observacion</th>"+
                        "<th>Registrado por</th>"+
                        "</tr></thead><tbody>";

            for (var i = 0; i < d.length; i++) {
                table += "<tr>";
                if (d[i].fuente_contacto != null) {
                    table += "<td>"+d[i].fuente_contacto.nombre+"</td>";
                }else{
                    table += "<td></td>";
                }
                if (d[i].campana_programa != null) {
                    table += "<td>"+d[i].campana_programa.programa.nombre +"</td>";
                }else{
                    table += "<td></td>";
                }
                table += "<td>"+d[i].estado_comercial.nombre+"</td>";
                if (d[i].vendedor != null) {
                    table += "<td>"+d[i].vendedor.name+"</td>";
                }else{
                    table += "<td></td>";
                }

                if(d[i].observacion != '')
                    observacion  = d[i].observacion;
                else
                    observacion = '-----';

                table += "<td>"+ observacion +"</td>";
                if (d[i].creado_por != null) {
                    table += "<td>"+d[i].creado_por.name+" <br>"+d[i].created_at+"</td>";
                }else{
                    table += "<td></td>";
                }
                table += "</tr>";
            }
            table += "</tbody></table>";
            console.log(table);
           // var table = "hola mundo" + id;
            tbl.fnOpen(row, table, 'details');
            botonimg.src = "/images/details_close.png";
        },
        error: function (xhr) {
            toastr.error('Error: '+xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
    });




    }
  }

function auditoriaShow(tipo_contacto_id) {
    $.ajax({
        type: 'POST',
        url: '/leads/auditoria',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            'id':tipo_contacto_id
        },
        success: function (data) {
            //console.log(data)
            $("#resultado-seguimiento").html(data);
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
function setEmail(sl){
    $("#asunto").val($(sl).find(':selected').data('asunto'));
    console.log($(sl).find(':selected').data('html'))
    ck_plantilla.setData($(sl).find(':selected').data('html'));
}
function para(email,id){
    $("#para").val(email);
    $("#transaccional_tipo_contacto_id").val(id);
}

function telefono(telf){
    console.log(telf)
}

function estado(tipo_contacto_id){
    $("#estado_tipo_contacto_id").val(tipo_contacto_id);
}

function seguimiento(tipo_contacto_id){
    $("#seguimiento_tipo_contacto_id").val(tipo_contacto_id);
}

function limpiar(){
    $("#formulario")[0].reset();
}
function ver_info(data) {
    console.log(data)
    $.ajax({
        type: 'POST',
        url: '/leads/show',
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
           console.log(d)
           $("#id").val(d.cod_lead);
           $("#nombre").val(d.nom_lead);
           $("#cedula").val(d.ced_lead);
           if(d.genero=='Masculino'){
            $("#Masculino").prop('checked',true);
           }else if(d.genero=='Femenino'){
            $("#Femenino").prop('checked',true);
           }
           $("#campana").val(d.campaingid);
           $("#oferta_academica").val(d.cod_oferta_academica);
           $("#programa").val(d.cod_programa);
           $("#email").val(d.email_lead);
           $("#otros").val(d.programa_adicional);
           $("#telefono").val(d.telf_lead);
           $("#direccion").val(d.direccion_lead);
           $("#procedencia").val('');
           $("#tipo_id").val(2);
           $("#fuente").val(d.cod_fuente_contacto);
           $("#medio").val(d.cod_medio_gestion);
           $("#vendedor").val(d.cod_usuario);
           $("#observacion").val(d.observacion);
        },
        error: function (xhr) {
            toastr.error('Error: '.xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
    });
}

function clear_data() {
    $('#name').val('');
    $('#id_entidad').val('');
    $('#email').val('');
    $('#password_confirmation').val('');
    $(':password').val('');
    $('#hide_id').val('');
    $('#idrol').val('');
    $('#custom-tabs-one-home-tab').click();
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

