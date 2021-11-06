
$(document).ready(function() {

$('.cmb_importar').select2({ theme: "bootstrap"  });

  
});

function esconderDiv(valor){ 
    if(valor=='C'){
        $('#opcionLead').hide();
    }else{
        $('#opcionLead').show();
    }
} 

function cargaNivel2(cod_nivel1){
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
                var option_nivel2='<option value="0" selected>SELECCIONE..</option>';
                for(i=0; i< data.length; i++){
                    option_nivel2 += '<option value="'+data[i].id+'">'+data[i].nombre+'</option>';
                }
                $('#nivel2').html(option_nivel2);
                $('#nivel2').select2({ width: 'resolve' ,theme: "bootstrap"  });
            },
            error: function(data) {
                console.log(data);
            }
        });    
}


function opcionAsesor(){ 
   var op=$('input:radio[name=asesor]:checked').val();
   var nom_campana = $('#nom_campana').val();
   var nivel2 = $('#nivel2').val();
   var sedes = $('#sedes').val();
   var formData = new FormData();
    formData.append('op_asesor',op);
    formData.append('nom_campana',nom_campana);
    formData.append('nivel2',nivel2);
    formData.append('sedes',sedes);

   $.ajax({
            type: 'POST',
            url: '/cmbAsesor_campana',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            processData: false,
            contentType: false,
           
            success: function (data) {
                var option_vendedor ='<option value="" selected>SELECCIONE..</option>';
                for(i=0; i< data.length; i++){
                    option_vendedor += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
                }
                $('#cod_vendedor').select2({ placeholder: "SELECCIONE..",
                    allowClear: true,width: 'resolve' ,theme: "bootstrap"  });
                $('#cod_vendedor').html(option_vendedor);

            },
            error: function (xhr) {
                toastr.error('Error: '.xhr.statusText + xhr.responseText);
            }
        });
    
}


function cargaCampana(cod_sede){
    var formData = new FormData();
    formData.append('cod_sede',cod_sede);
    var f=new Date();
    var fecha_actual =f.getFullYear() + "-"+ f.getMonth()+ "-" + f.getDate();
    
    $.ajax({
            type: 'POST',
            url: '/cmbCampana',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                var cmb_campana ='<select id="nom_campana" name="nom_campana" class="cmb_importar" onchange="opcionAsesor(); cargaProgramas(this.value);">'+
                 '<option value="" selected >SELECCIONE..</option>';
                for(i=0; i< data.length; i++){
                    // if(fecha_actual >= data[i].fecha_inicio &&   fecha_actual<=  data[i].fecha_fin){
                        cmb_campana += '<option value="'+data[i].id+'">'+data[i].nombre+'</option>';
                    // }
                }
                 cmb_campana +='</select>';
                $('#div_nom_campana').html(cmb_campana);
                $('#nom_campana').select2({ width: 'resolve' ,theme: "bootstrap"  });
            },
            error: function(data) {
                console.log(data);
            }
        });    
}

function cargaProgramas(codigo){
    var formData = new FormData();
    formData.append('codigo',codigo);
    var f=new Date();
    var fecha_actual =f.getFullYear() + "-"+ f.getMonth()+ "-" + f.getDate();
    
    $.ajax({
            type: 'POST',
            url: '/cmbProgramas',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
               // console.log(data[0].programa.nombre);
                var cmb_campana ='<select id="nivel2" name="nivel2" class="cmb_importar" onchange="opcionAsesor();" >'+
                 '<option value="" selected >SELECCIONE..</option>';
                for(i=0; i< data.length; i++){
                    
                        cmb_campana += '<option value="'+data[i].id+'">'+data[i].programa.nombre+'</option>';
                    
                }
                 cmb_campana +='</select>';
                $('#div_nivel2').html(cmb_campana);
                $('#nivel2').select2({ width: 'resolve' ,theme: "bootstrap"  });
            },
            error: function(data) {
                console.log(data);
            }
        });
}

  

function resetearFormulario(){
    //alert('5');
    $("#nom_campana").val('').trigger('change');
    $("#nivel1").val('').trigger('change');
    $("#nivel2").val('').trigger('change');
    $("#sedes").val('').trigger('change');
    $("#cod_vendedor").val('').trigger('change');
    $("#archivo").val('');
    $('#mensaje_error').html('');
    $('#fte_contacto').val('').trigger('change');
}

function importarDatos(){
  var opcion = $('input:radio[name=opcion]:checked').val();

  var archivo= document.getElementById("archivo");
  if(archivo.files && archivo.files[0]){
    var archivo_tarea= archivo.files[0];
  
  }else{
    var archivo_tarea="";
  }
  var formData = new FormData();
  if(opcion=='L'){
    console.log($("#fte_contacto").val());
    formData.append('fte_contacto',$("#fte_contacto").val());
   }
    formData.append('nom_campana',$("#nom_campana").val());
    formData.append('nivel1',$("#nivel1").val());
    formData.append('nivel2',$("#nivel2").val());
    formData.append('sede',$("#sedes").val());
    formData.append('cod_vendedor',$("#cod_vendedor").val());
    formData.append('archivo', archivo_tarea);
    formData.append('opcion', opcion);
    formData.append('procedencia', $("#procedencia").val());
    
    $.ajax({
        url: '/importarDatos',
        type: 'POST',              
        data: formData,
        enctype: 'multipart/form-data',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        processData: false,
        contentType: false,
        beforeSend: function(){
            $('#espera').show();   
        },
        success: function(data)
        {
                $('#espera').hide();
                if(typeof (data) != "string"){
                    var msg_error=' <div class="alert '+data['clase']+' fade show" role="alert">';
                    msg_error +='<ul>';
                    for (var i in data.mensaje_error) {
                         msg_error +='<li>'+data['mensaje_error'][i]+'</li>';
                    }
                    msg_error += '</ul></div>';
                    
                }

                if(typeof (data) == "string"){
                    var msg_error=' <div class="alert alert-success fade show" role="alert">';
                    msg_error +='<ul>';
                    msg_error +=data;
                    msg_error += '</ul></div>';
                }
                $('#archivo').val('');
                $('#mensaje_error').html(msg_error);

        },
        error: function(data)
        {   $('#espera').hide(); 
            var msg_error=' <div class="alert alert-danger fade show" role="alert">';
                    msg_error +='<ul>';
                    msg_error += '<li>Lo sentimos no se pudo realizar la importación</li>'
                    msg_error += '</ul></div>';
                       $('#mensaje_error').html(msg_error);

        }
    });
}

