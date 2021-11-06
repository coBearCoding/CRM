
$(document).ready(function() {
 
formularioCampana();

$("#fch_inicio").datepicker();
$("#fch_fin").datepicker();
});

function opciones(){
$('.fav_clr').on("select2:select", function (e) { 
           var data = e.params.data.text;
           if(data=='TODO'){
            $(".fav_clr > option").prop("selected","selected");
            $(".fav_clr").trigger("change");
           }
      });
}
function opciones_vendedor(){
$('.fav_clr_vendedor').on("select2:select", function (e) { 
           var data = e.params.data.text;
           if(data=='TODO'){
            $(".fav_clr_vendedor > option").prop("selected","selected");
            $(".fav_clr_vendedor").trigger("change");
           }
      }); 
}
function tblListaCampania(){
    
    //var formData = new FormData();
   
	$.ajax({
            type: 'POST',
            url: '/tblListaCampania',
            //data: formData,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            processData: false,
            contentType: false,
            success: function(data) {
                //console.log("DATA-->", data);
                $("#tblCampana").html(data);

                $('#tblListaCampana').DataTable({
                    "lengthChange": false,
                    "searching": true,
                    "info": true,
                    "language": {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total Registros)",
                        "infoPostFix": "",
                        "thousands": ",",

                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        },

                    },


                });

            },
            error: function(data) {
                // var respuesta = JSON.parse(data);
                // var body = respuesta['body'];
                console.log(data);
                

            }
        });
}

function formularioCampana(){
	$.ajax({
            type: 'GET',
            url: '/formularioCampana',
            processData: false,
            contentType: false,
            success: function(data) {
                var option_sede='<option value="" selected>SELECCIONE..</option>';
                var option_nivel1='<option value="" selected>SELECCIONE..</option>';
                var option_meta='<option value="" selected>SELECCIONE..</option>';
                var option_periodo='<option value="" selected>SELECCIONE..</option>';
               //var option_nivel2='<option value="0" selected>SELECCIONE..</option>';

                $("#formularioCampana").html(data['html']);
                $("#fch_inicio").datepicker();
                $("#fch_fin").datepicker();

                if(data['datos'][0].length>0){
                    option_sede += '<option value="T">TODO</option>';
                }
                for(i=0; i< data['datos'][0].length; i++){
                    option_sede += '<option value="'+data['datos'][0][i].id+'">'+data['datos'][0][i].nombre+'</option>';
                }
                for(i=0; i< data['datos'][1].length; i++){
                    option_nivel1 += '<option value="'+data['datos'][1][i].id+'">'+data['datos'][1][i].nombre+'</option>';
                }
                for(i=0; i< data['datos'][2].length; i++){
                    option_meta += '<option value="'+data['datos'][2][i].id+'">'+data['datos'][2][i].detalle+'</option>';
                }
                for(i=0; i< data['datos'][3].length; i++){
                    option_periodo += '<option value="'+data['datos'][3][i].id+'">'+data['datos'][3][i].nombre+'</option>';
                }
               // CKEDITOR.replace( 'detalle' );
               $('.cmb_campana').select2({ placeholder: "SELECCIONE..",
                    allowClear: true,width: 'resolve' ,theme: "bootstrap"  });
                $('#sedes').html(option_sede);
                $('#nivel1').html(option_nivel1);
                $('#meta').html(option_meta);
                $('#periodo').html(option_periodo);
                //$('#nivel2').html(option_nivel2);
               
                
                
                $('#vendedor').select2({ placeholder: "SELECCIONE..",allowClear: true,width: 'resolve' ,theme: "classic"  });

              //initSample();
            },
            error: function(data) {
                console.log(data);
            }
        });
}

function cargaNivel2(cod_nivel1){
    opcionAsesor();
    $('#nivel2').val('');

    var formData = new FormData();
    formData.append('cod_nivel1',cod_nivel1);
    $.ajax({
            type: 'POST',
            url: '/cmbNivel2',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
               var option_nivel2='';
                if(data.length>0){
                    option_nivel2 += '<option value="TODO">TODO</option>';
                }
                for(i=0; i< data.length; i++){
                    option_nivel2 += '<option value="'+data[i].id+'">'+data[i].nombre+'</option>';
                }
                $('#nivel2').select2({ placeholder: "SELECCIONE..",
                    allowClear: true,width: 'resolve' ,theme: "bootstrap"  });
                $('#nivel2').html(option_nivel2);
                
            },
            error: function(data) {
                console.log(data);
            }
        });    
}

function nuevaCampana(){

   var formData = new FormData();
    formData.append('cod_campana',$('#cod_campana').val());
    formData.append('cod_periodo',$('#cod_periodo').val());
    formData.append('nom_campana',$('#nom_campana').val());
    formData.append('fch_fin',$('#fch_fin').val());
    formData.append('fch_inicio',$('#fch_inicio').val());
    formData.append('nom_contacto',$('#nom_contacto').val());
    formData.append('email_contacto',$('#email_contacto').val());
    formData.append('sede',$('#sedes').val());
    formData.append('nivel1',$('#nivel1').val());
    formData.append('nivel2',$('#nivel2').val());
    formData.append('vendedor',$('#vendedor').val());
    formData.append('detalle',$('#detalle').val());
    formData.append('estadoCampana',$('input:radio[name=estadoCampana]:checked').val());
    formData.append('op_asesor',$('input:radio[name=asesor]:checked').val());
    formData.append('meta',$('#meta').val());
    //formData.append('meta',0);
    $.ajax({
            type: 'POST', 
            url: '/nuevaCampana',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            processData: false,
            contentType: false,
             beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
            },
            success: function(data) {
            $('#div_mensajes').addClass('d-none'); 
                $('#div_mensajes').removeClass('text-center');
                 
                
              
                if(data.mensaje != 'undefined'){
                
                   // var msg_error=' <div class="alert '+data.clase+' fade show" role="alert">';
                     msg ='<ul>';
                    if(data.opcion=='validar'){
                        for (var i in data.mensaje) {
                             msg +='<li>'+data.mensaje[i]+'</li>';
                        }
                    }else{
                            msg +='<li>'+data.mensaje+'</li>';
                    }
                    msg += '</ul>';
                        if(data.clase=='error'){

                            toastr.error(msg);
                        }else{
                            toastr.success(msg);
                            if($('#cod_campana').val() ==''){
                                resetearFormulario();
                            }
                        }
                     
                }
                    
                
                
               // $('#mensaje_error').html(msg_error);
                tblListaCampania()
                //data.forEach(element => console.log(element));
            },
            error: function(data) {
                $('#dv_formulario').show();
                $('#mensajes').hide(); 
                console.log(data);
            }
        });
}

function resetearFormulario(){
    $('#cod_periodo').val('');
    $('#nom_campana').val('');
    $('#fch_fin').val('');
    $('#fch_inicio').val('');
    $('#nom_contacto').val('');
    $('#email_contacto').val('');
    $('#detalle').val('');
   // CKEDITOR.instances.detalle.setData('');
    $("#sedes").val('').trigger('change');
    $("#nivel1").val('').trigger('change');
    $("#nivel2").val('').trigger('change');
    $("#meta").val('').trigger('change');
}

function editarCampana(cod_campana){
     
    $('#tblBusqueda').removeClass('active');
    $('#tab-c1-0').removeClass('active');
    $('#formCampanaTab').addClass('active');
    $('#tab_Formulario').addClass('active');
    //resetearFormulario();
    $('#nom_campana').val('');
     $("#sedes").html('');
     $("#nivel1").html('');
     $("#nivel2").html('');
     $("#meta").html('');
     $("#vendedor").html('');
      var formData = new FormData();
    formData.append('cod_campana',cod_campana);
    $.ajax({
            type: 'POST',
            url: '/formularioCampanaEditar',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('#div_mensajes').removeClass('d-none');
                $('#div_mensajes').addClass('text-center');
                $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
            },
            success: function(data) {
            
                $('#div_mensajes').addClass('d-none'); 
                $('#div_mensajes').removeClass('text-center');
               
                opcion_sede='';
                opcion_nivel1='';
                opcion_nivel2='';
                opcion_vendedor='';
                opcion_meta='';
                selected='';
                opcion_periodo='';
                
                $("#formularioCampana").html(data['html']);
                $('#nom_campana').val(data['datos'][2].nombre);
                $('#fch_inicio').val(data['datos'][2].fecha_inicio);
                $('#fch_fin').val(data['datos'][2].fecha_fin);
                $('#nom_contacto').val(data['datos'][2].ncontacto);
                $('#email_contacto').val(data['datos'][2].correo);
                $('#cod_campana').val(data['datos'][2].id);
                $('cod_periodo').val(data['datos'][2].periodo_id);

                if(data['datos'][2].op_asesor=='V'){
                    $('#asesorG').prop('checked',true);
                }else{$('#asesorT').prop('checked',true);}
                if(data['datos'][2].estado=='A'){
                    $('#estadoSi').prop('checked',true);
                }else{$('#estadoNO').prop('checked',true);}

                if(data['datos'][2].sede_id==null ){
                     opcion_sede += '<option value="" selected>SELECCIONE..</option>'
                }
                if(data['datos'][3]==null || data['datos'][3]==0){
                     opcion_nivel1 += '<option value="" selected>SELECCIONE..</option>'
                }
                if(data['datos'][2].meta_id==null || data['datos'][2].meta_id==0){
                     opcion_meta += '<option value="" selected>SELECCIONE..</option>'
                }
                 
                
                 if(data['datos'][9].length>1){
                        opcion_sede += '<option value="T" selected >TODO</option>'
                 }else{
                         opcion_sede += '<option value="T" >TODO</option>'
                 }

                 for(var i=0; i< data['datos'][0].length; i++){
                    selected='';
                    if(data['datos'][9].length==1){
                        if(data['datos'][9][0].sede_id == data['datos'][0][i].id){
                            selected ='selected'; 
                        }
                    }
                    opcion_sede += '<option value="'+data['datos'][0][i].id+'" '+selected+' >'+data['datos'][0][i].nombre+'</option>'
                 }
                 

                 for(var i=0; i< data['datos'][1].length; i++){
                    selected='';
                    if(data['datos'][3] == data['datos'][1][i].id){
                        selected ='selected'; 
                    }
                    opcion_nivel1 += '<option value="'+data['datos'][1][i].id+'" '+selected+' >'+data['datos'][1][i].nombre+'</option>'
                 }
                 opcion_nivel2 += '<option value="TODO" >TODO</option>';
                for(var i=0; i< data['datos'][4].length; i++){
                    selected='';
                    for(var j=0; j< data['datos'][7].length; j++){
                        if(data['datos'][7][j].nsecundario_id == data['datos'][4][i].id){
                            selected ='selected';
                        }
                    }
                    opcion_nivel2 += '<option value="'+data['datos'][4][i].id+'" '+selected+' >'+data['datos'][4][i].nombre+'</option>'
                 }
                 opcion_vendedor += '<option value="TODO" >TODO</option>';
                 debugger;
                 for(var i=0; i< data['datos'][6].length; i++){
                    selected='';
                    for(var j=0; j< data['datos'][5].length; j++){
                        if(data['datos'][5][j].user_id == data['datos'][6][i].id){
                            selected ='selected';
                        }
                    }
                    opcion_vendedor += '<option value="'+data['datos'][6][i].id+'" '+selected+' >'+data['datos'][6][i].name+'</option>'
                 }

                 for(var i=0; i< data['datos'][8].length; i++){
                    selected='';
                    for(var j=0; j< data['datos'][2].length; j++){
                        if(data['datos'][2][j].meta_id == data['datos'][8][i].id){
                            selected ='selected';
                        }
                    }
                    opcion_meta+= '<option value="'+data['datos'][8][i].id+'" '+selected+' >'+data['datos'][8][i].detalle+'</option>'
                 }

                  for(var i=0; i< data['datos'][10].length; i++){
                    selected='';
                    if(data['datos'][2].periodo_id == data['datos'][10][i].id){
                        selected ='selected'; 
                    }
                    opcion_periodo += '<option value="'+data['datos'][10][i].id+'" '+selected+' >'+data['datos'][10][i].nombre+'</option>';
                 }

                 $("#detalle").html(data['datos'][2].detalle);
                 $("#sedes").html(opcion_sede);
                 $("#nivel1").html(opcion_nivel1);
                 $("#nivel2").html(opcion_nivel2);
                 
                 $("#meta").html(opcion_meta);
                 $('#periodo').html(opcion_periodo);
                 $('.cmb_campana').select2({ width: 'resolve',theme: "bootstrap"  });
                 $('#nivel2').select2({ placeholder: "SELECCIONE..",
                    allowClear: true,width: 'resolve' ,theme: "bootstrap"  });
                $('#vendedor').select2({ placeholder: "SELECCIONE..",
                    allowClear: true,width: 'resolve' ,theme: "bootstrap"  });
                $("#vendedor").html(opcion_vendedor);
                $("#fch_inicio").datepicker();
                $("#fch_fin").datepicker();



            }
    });
     

    
}

function eliminarCampana(cod_campana, name){
  var formData = new FormData();
  formData.append('cod_campana',cod_campana);
  $.confirm({
    title: 'Eliminar Campaña!',
    content: 'Desea realizar la eliminación de la campaña ' + name + '?',
    buttons: {
        confirm: function () {
            $.ajax({
                type: 'POST',
                url: '/eliminarCampana',
                data: formData,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                processData: false,
                contentType: false,
                success: function(data) {
                    tblListaCampania()
                     toastr.success(data+' '+name);

                },
                error: function(data) {
                    // var respuesta = JSON.parse(data);
                    // var body = respuesta['body'];
                    console.log(data);
                    

                }
            });

         },
        cancel: function () {
            $.alert('Se ha cancelado la eliminación!');
        }
    }
  }); 

}

function opcionAsesor(){ 
    $("#vendedor").val('');
   var op=$('input:radio[name=asesor]:checked').val();
   var nivel1 = $('#nivel1').val();
   var sede = $('#sedes').val();
   var formData = new FormData();
    formData.append('op_asesor',op);
    formData.append('nivel1',nivel1);
    formData.append('sede',sede);
 
   $.ajax({
            type: 'POST',
            url: '/cmbAsesor',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            processData: false,
            contentType: false,
           
            success: function (data) {
                var option_vendedor ='';
                if(data.length>0){
                    option_vendedor += '<option value="TODO">TODO</option>';
                }
                for(i=0; i< data.length; i++){
                    option_vendedor += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
                }
                $('#vendedor').select2({ placeholder: "SELECCIONE..",
                    allowClear: true,width: 'resolve' ,theme: "bootstrap"  });
                $('#vendedor').html(option_vendedor);

            },
            error: function (xhr) {
                //toastr.error('Error: '.xhr.statusText + xhr.responseText);
            }
        });
    
}



function nsecundario(codigo){ 
  var formData = new FormData();
    formData.append('codigo',codigo);

   $.ajax({
            type: 'POST',
            url: '/nsecundario',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
               var prog="";
               if(data.length>0){
                    for(i=0; i< data.length; i++){
                    prog += '<div class="vertical-timeline-item vertical-timeline-element">'+
                               '<div>'+
                                '<span class="vertical-timeline-element-icon bounce-in"></span>'+
                                '<div class="vertical-timeline-element-content bounce-in">'+
                                    '<h4 class="timeline-title">'+ data[i].nombre +
                                    '</h4>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    }
                }else{
                   prog += '<div class="vertical-timeline-item vertical-timeline-element">'+
                               '<div>'+
                                '<span class="vertical-timeline-element-icon bounce-in"></span>'+
                                '<div class="vertical-timeline-element-content bounce-in">'+
                                    '<h4 class="timeline-title">No hay programas relacionados' +
                                    '</h4>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                }
                 $('#campana_programa').html(prog);

            },
            error: function (xhr) {
                //toastr.error('Error: '.xhr.statusText + xhr.responseText);
            }
        });
    
}