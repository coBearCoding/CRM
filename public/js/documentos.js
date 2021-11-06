$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    view_table();

    $("#btn_guardar").click(function(e){
    	e.preventDefault();

    	if (!$("#formulario").valid()) {
            return false;
        }


    	var data = new $('#formulario').serialize();
        $.ajax({
            type: 'POST',
            url: '/documentos/register',
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
                //$('#horarioModal').modal('toggle');
                var d = JSON.parse(data);
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                    view_table();
                    limpiar();
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

    $("#formulario").validate({
        ignore: [],
        rules: {
          'servicio'          : {required: true},
          'tipo'            : {required: true},
          'nombre'            : {required: true},
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
});

function limpiar(){
    $("#id").val('');
    $("#servicio").prop('disabled',false)
    $("#formulario")[0].reset();
}

function editar(id,servicio,nombre,tipo,requerido){
    
    $("#id").val(id)
    $("#servicio").val(servicio)
    $("#servicio").prop('disabled',true)
    $("#nombre").val(nombre);
    $("#tipo").val(tipo);
    if (requerido == 'S') {
    	$("#si").prop('checked',true)
    }
    if (requerido == 'N') {
    	$("#no").prop('checked',true)
    }
    $('#horarioModal').modal('toggle');
}

function abrir(botonimg, id) {
    //debugger;
    //let botonimg = opt.toElement;
    let row = $(botonimg).parents('tr')[0];
    var tbl = $('#tbl_horarios').dataTable();
    if (tbl.fnIsOpen(row)) {
      tbl.fnClose(row);
      botonimg.src = "/images/details_open.png";
    } else {
      $.ajax({
        type: 'POST',
        url: '/horario/detalle',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id": id
        },
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
        success: function (d) {
            console.log(d)
            var table = "<table class='table table-bordered' with='100%'><thead class='thead-light'><tr>"+
                        "<th>Día</th>"+
                        "<th>Hora de Inicio</th>"+
                        "<th>Hora Fin</th>"+
                        "<th>Inicio Descanso</th>"+
                        "<th>Fin Descanso</th>"+
                        "<th>Detalle</th>"+
                        "<th></th>"+
                        "</tr></thead><tbody>";

            for (var i = 0; i < d.length; i++) {
                table += "<tr>";
                if (d[i].dia != null) {
                    table += "<td>"+d[i].dia.nombre+"</td>";
                }else{
                    table += "<td></td>";
                }
                if (d[i].hora_ini != null) {
                    table += "<td>"+d[i].hora_ini.split('.')[0] +"</td>";
                }else{
                    table += "<td></td>";
                }
                table += "<td>"+d[i].hora_fin.split('.')[0]+"</td>";
                if (d[i].descanso_ini != null) {
                    table += "<td>"+d[i].descanso_ini.split('.')[0]+"</td>";
                }else{
                    table += "<td></td>";
                }
                table += "<td>"+d[i].descanso_fin.split('.')[0]+"</td>";
                if (d[i].intervalo != null) {
                    table += "<td> Intervalo: "+d[i].intervalo+" <br> Turnos: "+d[i].max_turno+"</td>";
                }else{
                    table += "<td></td>";
                }
                table += "<td><a href='#' class='btn btn-sm btn-neutral' data-toggle='modal' "+
                         "data-target='#horarioModal' onclick='editar("+JSON.stringify(d[i])+")'>Editar Horario</a></td>";
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
            Swal.close();
        },
    });


  

    }
  }


function eliminar(data,name){
    $.confirm({
        title: 'Eliminar usuario!',
        content: '¿Desea eliminar el usuario usuario '+name+'?',
        buttons: {
            confirm: function () {
                $.ajax({
                    type: 'POST',
                    url: '/horario/delete',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "id": data
                    },
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
                    success: function (d) {
                        if (d['msg'] == 'error') {
                            toastr.error(d['data']);
                        } else {
                            toastr.success(d['data']);
                            view_table();
                            limpiar();
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
            cancel: function () {
                $.alert('Se ha cancelado la eliminación!');
            }
        }
    });
}

function view_table() {

    $.ajax({
        type: 'POST',
        url: '/documentos/data',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content')
        },
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
            $('#div_tabla').html(data);
            $('#tbl_documentos').DataTable({
            	//"dom":"lfrtip",
                "language": {
                	//"paginate":{previous:"<i class='fas fa-angle-left'>",next:"<i class='fas fa-angle-right'>"
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
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "order": [[0, "desc"]]
            });
            // acciones();
            $("#tbl_documentos_wrapper").find('div.row').first().addClass('p-4');
            $("#tbl_documentos_wrapper").find('div.row').last().addClass('p-4');
        },
        error: function (xhr) { // if error occured
            toastr.error('Error: ' + xhr.statusText + xhr.responseText);
        },
        complete: function () {
             	swal.close()
        },
        dataType: 'html'
    });
}