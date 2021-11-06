var ck_plantilla;
var tbl_leads;
var rows;
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

     $("body").tooltip({ selector: '[data-toggle=tooltip]' });

    $('#plantilla').select2({ dropdownParent: "#envioModal" });

    $("#fecha_seguimiento").click(function(){
        if($(this).is(':checked')){
            $("#estado_search").val(3);
            $("#estado_search").prop('disabled',true);
        }else{
            $("#estado_search").val('');
            $("#estado_search").prop('disabled',false);
        }

    })

   // $('[data-toggle="popover"]').popover();
     /*$("#otros").select2({
        placeholder: "SELECCIONE..",
    });
    $("#campana").select2({
    placeholder: "SELECCIONE..",
    });*/

    /*ClassicEditor
        .create( document.querySelector( '#txt_plantilla' ) )
        .then( editor => {
               // console.log( editor );
                ck_plantilla=editor;
        } )
        .catch( error => {
                console.error( error );
        } );*/
    //$("body").tooltip({ selector: '[data-toggle=tooltip]' });

    $("#estado_comercial_modal").change(function(){
        if($(this).val()=='3'){ //estado de seguimiento
            $("#seguimiento").show(250);
        }else{
            $("#seguimiento").hide(250);
            $("#seguimiento_modal").val('');
        }

        if($(this).val()=='2'){ //estado de desinteres
            $("#desinteres").show(250);
        }else{
            $("#desinteres").hide(250);
            $("#desinteres_modal").val('');
        }
    });

    $("#estado_comercial_modal").change(function(){
        $("#desinteres_nombre").val($( "#estado_comercial_modal option:selected" ).text());
    });

    $("#tipo_encuesta").change(function(){
        if($(this).val()!=''){ //estado de seguimiento
            loadPregunta( $("#pregunta_tipo_contacto_id").val(),$("#pregunta_nivel_primario_id").val(),$(this).val());
        }
    });

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
                    rows.innerText = $( "#estado_comercial_modal option:selected" ).text();
                    //$("#tbl_leads").DataTable().ajax.reload(null,false);
                    //clear_data();
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
                var d = JSON.parse(data);
                console.log(data);
                $('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                    $("#tbl_leads").DataTable().ajax.reload(null,false);
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

    $("#btn_editar").click(function () {
        /*if (!$("#formulario_contacto").valid()) {
            return false;
        }*/
        var data = new $('#formulario_contacto').serialize();

        $.ajax({
            type: 'POST',
            url: '/leads/edit',
            data: data,
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
            },
            success: function (data) {
                var d = JSON.parse(data);
                console.log(data);
                $('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                    $("#tbl_leads").DataTable().ajax.reload(null,false);
                }
                $("#formulario_contacto")[0].reset();
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

    $("#btn_preguntas").click(function () {

        var data = new $('#formulario_preguntas').serialize();

        $.ajax({
            type: 'POST',
            url: '/leads/preguntas/post',
            data: data,
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="15%" height="15%" />');
            },
            success: function (data) {
                var d = JSON.parse(data);
                console.log(data);
                $('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
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
                'templateid':$("#plantilla").val(),
                'id':$("#transaccional_tipo_contacto_id").val(),
                'nombre':$("#nombre_lead").val(),
                'grado_template':$("#grado_template").is(':checked') ? 'S' : 'N'
            },
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
            },
            success: function (data) {
                console.log(data);
                var d = JSON.parse(data);
                $('#div_mensajes').hide();
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                    //$("#tbl_leads").DataTable().ajax.reload(null,false);
                    clear_data();
                }
                //document.getElementById('view_html').innerHTML = '';
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
                    $("#tbl_leads").DataTable().ajax.reload(null,false);
                    limpiar();
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
          'telefono'          : {required: true},
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
          'fch_prox_contacto'            : {required: true},
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
                $("#vendedor").append(optionvendedor);

                var vendedor_id=$("#vendedor_hide").val();
                var programa_id=$("#programa_hide").val();
                $("#programa").val(programa_id);
                $("#vendedor").val(vendedor_id);
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


    $("#campain_search").change(function(){
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
                  var option="<option value=''>Seleccione</option>";
                for (var i = 0; i < datos['programas'].length; i++) {
                    if (datos['programas'][i].programa != null) {
                        option += "<option value='"+datos['programas'][i].programa.id+"'>"+datos['programas'][i].programa.nombre+"</option>";
                    }
                }
                $("#programa_search").html('')
                $("#programa_search").append(option)

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

    $("#oferta_search").change(function(){
        $.ajax({
            type: 'POST',
            url: '/leads/oferta/campana',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'id':$(this).val()
            },
            success: function (data) {
                //  $('#formregisterdiv').html(data);

                var datos = JSON.parse(data);
                var option="<option value=''>Seleccione</option>";
                for (var i = 0; i < datos['campanias'].length; i++) {
                    option += "<option value='"+datos['campanias'][i].id+"'>"+datos['campanias'][i].nombre+"</option>";
                }
                $("#campain_search").html('');
                $("#campain_search").append(option);
                var optionp="<option value=''>Seleccione</option>";
                for (var i = 0; i < datos['programas'].length; i++) {
                    optionp += "<option value='"+datos['programas'][i].id+"'>"+datos['programas'][i].nombre+"</option>";
                }
                $("#programa_search").html('');
                $("#programa_search").append(optionp);
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
   $("#tbl_leads").DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: '/leads/data',
             method: 'POST',
            data: function (d) {
                d.estado = $('#estado_search').val() != "" ? $('#estado_search').val() : $("#fecha_seguimiento").is(':checked') ? 3 : null;
                d.fuente = $('#fuente_search').val() != "" ? $('#fuente_search').val() : null;
                d.fecha_ini = $("#fecha_ini").val() + ' 00:00:00';
                d.fecha_fin = $("#fecha_fin").val() + ' 23:59:59';
                d.campain_search = $('#campain_search').val() != "" ? $('#campain_search').val() : null;
                d.programa_search = $('#programa_search').val() != "" ? $('#programa_search').val() : null;
                d.oferta_search = $('#oferta_search').val() != "" ? $('#oferta_search').val() : null;
                d.asesor_search = $('#asesor_search').val() != "" ? $('#asesor_search').val() : null;
                d.fecha_seguimiento = $("#fecha_seguimiento").is(':checked') ? 'S' : 'N';
            }
        },
        "columns":[
            //Abrir Button
            {render: function(data, type, full, meta){
                return (
                    "<img onclick='abrir(this,"+full.contacto_tipo_id+")'"
                    +"src='/images/details_open.png' style='cursor: pointer;'>"
                )
            }},
            {data: 'created_at'},
            {data: 'correo'},
            {data: 'nombre'},
            //Datos Personales
            {render: function(data, type, full, meta){
                return (
                    "<a href='#' data-toggle='modal' data-target='.modal-contacto' onclick='editar("+ full.contacto_tipo_id +")'>"
                    + full.nombre
                    +"</a>"
                    + "<br/>"
                    + full.correo
                    + "<br/>"
                    + full.telefono)
            }},
            //Campana
            {render: function(data, type, full, meta){
                return (
                    "<b> Campana: </b>"
                    + full.campana
                    + "<br/>"
                    + "<b> Programa: </b>"
                    + full.programa
                );
            }},
            // {data: 'asesor'},
            {render: function(data, type, full, meta){
               return(
                full.asesor
                );
            }},
            {data: 'estado_comercial'},
            {data: 'fuente_contacto'},
            {data: 'created_at'},
            // Botones de Opciones
            {render: function(data, type, full, meta){
                var secondary_text = '';
               var text =
                    "<div class='btn-group'>"
                        +"<button data-toggle='tooltip' data-placement='top' title=''"
                        +"type='button' class='btn btn-success' onclick='llamada("
                        + full.telefono +",`"
                        + full.nombre +"`,"
                        + full.contacto_tipo_id +")'"
                        +"data-original-title='Llamar'>"
                        +"<i class='fas fa-phone'></i>"
                        +"</button>"

                        + "<button onclick='para(`"
                        +full.correo+"`,"
                        +full.contacto_tipo_id+",`"
                        + full.nombre+"`)'"
                        +"data-toggle='modal' data-target='.modal-envio'"
                        +"title='Envio Transaccional'  title='Editar'"
                        +"type='button' class='btn btn-primary'>"
                        +"<i class='fa fa-envelope'></i>"
                        +"</button>"

                        +"<button data-toggle='modal' data-target='.modal-seguimiento-show'"
                        +"title='Seguimiento de Leads historial' onclick='auditoriaShow("+full.contacto_tipo_id+")'"
                        +"type='button' class='btn btn-secondary'>"
                        +"<i class='fa fa-tasks'></i>"
                        +"</button>"
                        +"<button onclick='preguntasModal("
                        +full.contacto_tipo_id+",` `)'"
                        +" data-toggle='modal' data-target='.modal-pregunta'"
                        +"  title='Preguntas' type='button' class='btn btn-primary'>"
                        +"<i class='fas fa-question'></i>"
                        +"</button>"
                    +"</div>"
                    +"<br/>"
                    +"<div class='btn-group' style='padding-top: 15px'>"
                        + "<button data-toggle='modal' data-target='.modal-lead'"
                        +" title='Editar' onclick='ver_info("+full.contacto_tipo_id+")' type='button'"
                        +"class='btn btn-info'><i class='fa fa-edit'></i>"
                        +"</button>"

                        +"<button data-toggle='modal' data-target='.modal-estado'"
                        +" title='Estado Comercial' onclick='estado("+full.contacto_tipo_id+","+full.ContactoHistID+",this)'"
                        +" type='button' class='btn btn-primary'>"
                        +"<i class='fa fa-archive'></i>"
                        +"</button>"

                        +"<a data-toggle='tooltip' data-placement='top'"
                        +" title='WhatsApp' target='_blank' onclick='Registro("+full.contacto_tipo_id+")'"
                        +"href='https://api.whatsapp.com/send?phone=+593"+full.telefono
                        +"&text=Hola "+full.nombre+", un gusto saludarte...' "
                        +" class='btn btn-success'>"
                        +"<i class='fa fa-whatsapp' aria-hidden='true'></i>"
                        +"</a>";
                        if(full.user_connected == 1 || full.user_connected == 2 || full.user_connected == 4
                            || full.user_connected == 9){
                          var secondary_text =  "<button data-toggle='tooltip' data-placement='top' title='Eliminar' onclick='eliminar({{$contacto_tipo_id}},'{{ $contacto_tipo['contacto']['nombre'] }}','Eliminar')' type='button' class='btn btn-danger'><i class='fas fa-trash'></i></button>";
                        }
                   var third_text ="</div>";

                   return text + secondary_text + third_text;
            }}
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
                "searchable": false
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
                "searchable": true
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
                "searchable": true
            },
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
        "searchable": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "order": [[ 1, "desc" ]]
    });
}

function busqueda_search(){
    $("#tbl_leads").DataTable().ajax.reload();
}
function abrir(botonimg, id) {
    //debugger;
    //let botonimg = opt.toElement;
    let row = $(botonimg).parents('tr')[0];
    var tbl = $('#tbl_leads').dataTable();
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
                    if (d[i].campana_programa.programa != null) {
                        table += "<td>"+d[i].campana_programa.programa.nombre +"</td>";
                    }else{
                        table += "<td></td>";
                    }
                }else{
                    table += "<td></td>";
                }
                table += "<td>"+d[i].estado_comercial.nombre+"</td>";
                if (d[i].vendedor != null) {
                    table += "<td>"+d[i].vendedor.name+"</td>";
                }else{
                    table += "<td></td>";
                }
                if(d[i].observacion != '' && d[i].observacion != null && d[i].observacion != 'null')
                    observacion  = d[i].observacion;
                else
                    observacion = '-----';

                table += "<td>"+ observacion +"</td>";
                table += "<td>";
                if (d[i].creado_por != null) {
                    table += d[i].creado_por.name+" <br>";
                }
                if (d[i].created_at != null) {
                    var mes = new Date(d[i].created_at).getMonth()+1;
                    var fecha = new Date(d[i].created_at).getFullYear() +'-'
                    + mes +'-'
                    + new Date(d[i].created_at).getDate() +' '
                    +new Date(d[i].created_at).toLocaleTimeString();
                    table += fecha+"</td>";
                }else{
                    table += "</td>";
                }
                table += "</tr>";
            }
            table += "</tbody></table>";
            //console.log(table);
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
        beforeSend: function () {
            //$('#div_mensajes').removeClass('d-none');
            //$('#div_mensajes').addClass('text-center');
            $('#resultado-seguimiento').html('<img src="../images/load.gif" width="15%" height="15%" />');
        },
        success: function (data) {
            //console.log(data)
            $("#resultado-seguimiento").html('');
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

function preguntasModal(tipo_contacto_id,nivel_primario_id) {
    $("#pregunta_tipo_contacto_id").val(tipo_contacto_id);
    $("#pregunta_nivel_primario_id").val(nivel_primario_id);
    $("#preguntas").html('');
    $("#tipo_encuesta").val('');

}
function loadPregunta(tipo_contacto_id,nivel_primario_id,tipo_encuesta_id) {
    //$("#pregunta_tipo_contacto_id").val(tipo_contacto_id);
    //$("#pregunta_nivel_primario_id").val(nivel_primario_id);
    $.ajax({
        type: 'POST',
        url: '/leads/preguntas',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            'id':tipo_contacto_id,
            'nivel_primario_id':nivel_primario_id,
            'tipo_encuesta_id':tipo_encuesta_id,
        },
        beforeSend: function () {
            //$('#div_mensajes').removeClass('d-none');
            //$('#div_mensajes').addClass('text-center');
            $('#preguntas').html('<img src="../images/load.gif" width="15%" height="15%" />');
        },
        success: function (data) {
            data = JSON.parse(data)
            console.log(data.preguntas.length)
            var html_rspta = '';
            $("#preguntas").html('');
            if (data.preguntas.length > 0) {
                for (var i = 0; i < data.preguntas.length; i++) {
                    html_rspta += '<div class="row">'+
                             '<div class="col">'+
                             '<div class="form-group">'+
                            '<label for="campo_'+data.preguntas[i].id+'" class="col-form-label">'+data.preguntas[i].texto+'</label>'
                            if (data.preguntas[i].tipo_campo == 'COMBO') {
                                html_rspta += '<select class="form-control" id="campo_'+data.preguntas[i].id+'" name="campo_'+data.preguntas[i].id+'">';
                                var opt = data.preguntas[i].respuestas.split(',');
                                for (var j = 0; j < opt.length; j++) {
                                    html_rspta += '<option value="'+opt[j]+'">'+opt[j]+'</option>';
                                }
                                html_rspta += '</select>';
                            }else{
                                html_rspta +=  '<textarea class="form-control" rows="5" id="campo_'+data.preguntas[i].id+'" name="campo_'+data.preguntas[i].id+'"></textarea>';
                            }

                        html_rspta +=  '</div>'+
                        '</div>'+
                        '</div>';
                }
                $("#preguntas").html(html_rspta);
            }else{
                $("#preguntas").html("<br/><p>No se encontraron preguntas para este tipo de encuesta</p>");
            }


             for (var i = 0; i < data.respuestas.length; i++) {
                if (data.respuestas[i].respuesta!='') {
                    $("#campo_"+data.respuestas[i].pregunta_id).val(data.respuestas[i].respuesta);
                    $("#campo_"+data.respuestas[i].pregunta_id).prop('readonly',true);
                    $("#campo_"+data.respuestas[i].pregunta_id).prop('disabled',true);
                }
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
}
function setEmail(sl){
    $("#asunto").val($(sl).find(':selected').data('asunto'));
    console.log($(sl).find(':selected').data('html'))
    //ck_plantilla.setData($(sl).find(':selected').data('html'));
    //$("#texto_plantilla").show();
    //$('#texto_plantilla').html($(sl).find(':selected').data('html'))
    var url = '/leads/html/'+$(sl).val();
    $('#view_template').prop('href',url);

}
function para(email,id,nombre_lead){
    $("#para").val(email);
    $("#transaccional_tipo_contacto_id").val(id);
    $("#nombre_lead").val(nombre_lead);
}

function telefono(telf){
    console.log(telf)
}

function estado(tipo_contacto_id,id,btn){
    rows = $(btn).parents('tr').find("td")[4];
    //debugger
    console.log(rows)
    $("#estado_tipo_contacto_id").val(tipo_contacto_id);
    $("#estado_contacto_historico_id").val(id);
    $("#estado_comercial_modal").val("");
     $("#observacion_estado").val("");
      $("#desinteres_modal").val("");
       $("#seguimiento_modal").val("");
       $("#medio_gestion_seguimiento").val("");
       $("#fch_prox_contacto").val("");
       $("#medio_gestion_seguimiento").val("");
       $("#hora").val("");
       $("#seguimiento").hide()
       $("#desinteres").hide()


}

function seguimiento(tipo_contacto_id){
    $("#seguimiento_tipo_contacto_id").val(tipo_contacto_id);
}

function limpiar(){
    $("#formulario")[0].reset();
    $("#editar").val('');
    $("#contacto_id").val('');
    //$("#tipo_id").val('');
    $("#vendedor_hide").val('');
    $("#programa_hide").val('');
}

function editar(data){
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
           $("#contacto_id_edit").val(d.contacto_id);
           $("#nombre_edit").val(d.contacto.nombre);
           $("#cedula_edit").val(d.contacto.cedula);
           if(d.contacto.genero=='Masculino'){
            $("#Masculino_edit").prop('checked',true);
           }else if(d.contacto.genero=='Femenino'){
            $("#Femenino_edit").prop('checked',true);
           }
           $("#correo_edit").val(d.contacto.correo);
           $("#otros").val(d.programa_adicional);
           $("#telefono_edit").val(d.contacto.telefono);
           $("#direccion_edit").val(d.contacto.direccion);
           $("#procedencia_edit").val(d.contacto.procedencia);
           $("#tipo_estudiante_edit").val(d.contacto.tipo_estudiante_id);
        },
        error: function (xhr) {
            toastr.error('Error: '.xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
    });
}


function ver_info(data) {
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
           $("#editar").val("SI");
           $("#campana").val(d.contacto_historico_last.campana_programa.campana.id);
           $("#campana").trigger('change');
           $("#vendedor_hide").val(d.contacto_historico_last.vendedor_id);
           $("#programa_hide").val(d.contacto_historico_last.campana_programa.id);
           $("#contacto_id").val(d.contacto_id);
           $("#nombre").val(d.contacto.nombre);
           $("#cedula").val(d.contacto.cedula);
           if(d.contacto.genero=='Masculino'){
            $("#Masculino").prop('checked',true);
           }else if(d.contacto.genero=='Femenino'){
            $("#Femenino").prop('checked',true);
           }
           //$("#oferta_academica").val(d.cod_oferta_academica);
           $("#email").val(d.contacto.correo);
           $("#otros").val(d.programa_adicional);
           $("#telefono").val(d.contacto.telefono);
           $("#direccion").val(d.contacto.direccion);
           $("#procedencia").val(d.contacto.procedencia);
           $("#tipo_id").val(1);
           $("#fuente").val(d.contacto_historico_last.fuente_contacto_id);
           $("#medio").val(d.cod_medio_gestion);
           $("#observacion").val(d.contacto_historico_last.observacion);
           $("#programa").val(d.contacto_historico_last.campana_programa.id);
           $("#vendedor").val(d.contacto_historico_last.vendedor_id);
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

function eliminar(cod,name) {
     var data = cod;
    var name = name;
    console.log(data);
    $.confirm({
        title: "¡Eliminar Información!",
        content: '¿Desea eliminar el lead ' + name + '?',
        buttons: {
            confirm: {
                text: 'Eliminar',
                btnClass:'btn-red',
                action:function () {
                    $.ajax({
                        type: 'POST',
                        url: '/delete_leads',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                             "id" : data
                         },
                         beforeSend: function() {
                            $('#div_mensajes').removeClass('d-none');
                            $('#div_mensajes').addClass('text-center');
                            $('#mensajes').html('<img src="../images/load.gif" width="10%" height="10%" />');
                        },
                        success: function (d) {
                            if (d['msg'] == 'error') {
                                toastr.error(d['data']);
                            } else {
                                toastr.success(d['data']);
                                $("#tbl_leads").DataTable().ajax.reload(null,false);
                            }
                        },
                        error: function (xhr) {
                            toastr.error('Error: '+xhr.statusText + xhr.responseText);
                        },
                        complete: function () {
                            $('#div_mensajes').addClass('d-none');
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

function Registro(codigo){
    $.ajax({
        type: 'POST',
        url: '/leads/registro',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id": codigo
        },
        beforeSend: function () {
            $('#div_mensajes').removeClass('d-none');
            $('#div_mensajes').addClass('text-center');
            $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
        },
        success: function (d) {
          if (d['msg'] == 'error') {
                toastr.error(d['data']);
            } else {
                toastr.success(d['data']);
            }
        },
        error: function (xhr) {
            toastr.error('Error: '+xhr.statusText + xhr.responseText);
        },
        complete: function () {
            $('#div_mensajes').addClass('d-none');
        },
    });
}

