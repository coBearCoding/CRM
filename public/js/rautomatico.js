$(document).ready(function(){
//formWizards();
 formRespuesta();
//$("#paso1").hide();


 $('.cmb_nivel2_multiple').select2({ allowClear: true,placeholder: " " ,width: 'resolve' ,theme: "bootstrap" }); 
});
 
function formRespuesta(){
   resetearFormulario();
    $.ajax({
            async: false,
            type: 'GET',
            url: '/wizardFormRespAuto',
            async: false,
            processData: false,
            contentType: false,
            success: function(data) {
                $("#respAutomatica").html(data);
                $('.cmb_nivel2_multiple').select2({allowClear: true,placeholder: " " ,width: 'resolve' ,theme: "bootstrap" }); 
            },
            error: function(data) {
                console.log(data);
            }
        });
}

function opcionPlantilla(){
    $('#tbl_archivo > tbody').empty();
    var op_plantilla = $('input:radio[name=plantilla]:checked').val();
    var form_plantilla = $('input:radio[name=formPlantilla]:checked').val();
    var cod_respuesta= $('#cod_respuesta').val();
    if(op_plantilla != undefined && form_plantilla != undefined){
        var formData = new FormData();
        formData.append('op_plantilla', op_plantilla);
        formData.append('form_plantilla', form_plantilla);
        formData.append('id', cod_respuesta);
        $.ajax({
            url: '/opcionPlantilla',
            type: 'POST',              
            data: formData,
            enctype: 'multipart/form-data',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            processData: false,
            contentType: false,
            beforeSend: function(){
                  
            },
            success: function(data)
            { 
                if(data.op_plantilla=='P'){
                    console.log(data['listNivel2'].length);
                    var sel_prog='<div class="position-relative  form-group row">'+
                                    '<label for="exampleEmail" class="col-sm-12 col-form-label">Seleccionar el Programa para el archivo : </label>'+
                                    '<div class="col-sm-12">'+
                                    '<select id="niv_arch" name="niv_arch"  class="form-control sel_programa" >';
                         sel_prog +=' <option value="">SLECCIONE..</option>';           
                    for(i=0; i< data['listNivel2'].length; i++){
                        sel_prog +=' <option value="'+data['listNivel2'][i].cod_nivel2+'">'+data['listNivel2'][i].nom_nivel2+'</option>';

                    }
                     sel_prog += '</select>'+
                                  '</div>'+
                                  '</div>';                 
                    
                }
                $("#mailing_programa").html(data.html);

                $("#prog_arch").html(sel_prog);
                $('#niv_arch').select2({width: 'resolve' ,theme: "bootstrap" });
                $('.cmb_nivel2_multiple').select2({allowClear: true ,width: 'resolve' ,theme: "bootstrap" , placeholder :' '}); 
            },
            error: function(data)
            {   
                console.log(data);
            }
        });
    }
}

function guardarDatos(){
    var formData = new FormData();
    var nombre = $('#nombre').val();
    var asunto = $('#asunto').val();
    var plantilla=$('input:radio[name=formPlantilla]:checked').val();
    var cod_respuesta =  $('#cod_respuesta').val();
        
    if(nombre ==''){
        toastr.error('El nombre es obligatorio');
        return false;
    }
    if(asunto ==''){
        toastr.error('El asunto es obligatorio');
        return false;
    }
    if(plantilla ==undefined || plantilla =='' ||plantilla =='undefined'){
        toastr.error('Seleccionar el formulario');
        return false;
    }
    var op_plantilla=$('input:radio[name=plantilla]:checked').val();
    if(op_plantilla=='P'){
        var cont = $('#cont_select').val();
        if(cont !=''||cont !='undefined'){
            var prog=[];
            var progP=[];
            var progP2=[];
            var cont_sel=0;
            var progMail=[];
          
            for(var i=1; i< cont; i++){
                var val_sel = $('#'+i).val();
                for(var j=0; j<val_sel.length; j++){
                    console.log(val_sel[j]);
                    var prog1=val_sel[j].split("_",1);
                    var prog2=val_sel[j].split("_");
                    progP.push(prog1); 
                    progP2.push(prog2);

                }
             
                if(val_sel !=''){
                    cont_sel++;
                   prog.push(val_sel); 
                }

                
            }
            if(cont_sel ==0){
                toastr.error('Debe de seleccionar una plantilla');
                return false;
            }
        //    console.log('programass::'+progP2);
        formData.append('programa3',progP2);
        formData.append('programa2',progP);
        formData.append('programa',prog);
        }
    }else {
        var mailing=$('input:radio[name=mailing]:checked').val(); 
        if(mailing ==undefined || mailing =='' ||mailing =='undefined'){
            toastr.error('Debe de seleccionar una plantilla');
            return false;
        }
        formData.append('mailing',mailing);

    }
    tr = []; 
    tr_programa = []; 
    temp = document.getElementsByClassName("registro"); 
    temp_prog = document.getElementsByClassName("registro_prog"); 
    //console.log(temp_prog);
   
    if(temp.length==temp_prog.length ){
        if(temp.length>0){
            for(var i=0;i<temp.length;i++){ 
                tr.push(temp[i].innerText); 
            }
            formData.append('archivos',tr);
        }

        if(temp_prog.length>0){
            for(var i=0;i<temp_prog.length;i++){ 
                tr_programa.push(temp_prog[i].innerText); 
            }
            formData.append('programa_arc',tr_programa);
        }
        console.log('programas');
        console.log(tr_programa);
    }

    
    formData.append('nombre',nombre);
    formData.append('asunto',asunto);
    formData.append('plantilla',plantilla);
    formData.append('op_plantilla',op_plantilla);
    formData.append('plantilla',plantilla);
    formData.append('cod_respuesta',cod_respuesta);    
    
    
    $.ajax({
            type: 'POST',
            url: '/datosGuardado',
            data: formData,
            async:false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            processData: false,
            contentType: false,
            success: function(data) {
                if(data.opcion=='no'){
                toastr.error(data.datos);
                }else{
                toastr.success(data.datos);
                resetearFormulario();
                }
            },
            error: function(data) {
                console.log(data);
            }
    });

}

/*
function cmbCampana(form_id){
    var op_plantilla= $('input:radio[name=plantilla]:checked').val();
    var formData = new FormData();
    formData.append('form_id',form_id);
    formData.append('op_plantilla',op_plantilla);
    $.ajax({
            type: 'POST',
            url: '/datosSeleccionFormulario',
            data: formData,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            processData: false,
            contentType: false,
            success: function(data) {
              
               
               $("#mailing_programa").html(data);
               if(op_plantilla=='P'){
                    $('.cmb_nivel2_multiple').select2({ allowClear: true,placeholder: " " ,width: 'resolve' ,theme: "bootstrap" });
                     $('#niv_arch').select2({allowClear: true ,width: 'resolve' ,theme: "bootstrap"  });  
               }
               
               
               
            },
            error: function(data) {
                console.log(data);
            }
    });
}
*/
function guardarNsecundario(cod_mail,form_id){
    var nivel2 = $("#"+cod_mail).val();
    
    var formData = new FormData();
    formData.append('nivel2',nivel2);
    formData.append('mailing',cod_mail);
    formData.append('formulario',$('input:radio[name=formPlantilla]:checked').val());
    formData.append('nombre',$('#nombre').val());
    formData.append('asunto',$('#asunto').val());
    formData.append('op_plantilla',$('input:radio[name=plantilla]:checked').val());

    $.ajax({
            type: 'POST',
            url: '/guardarNsecundario',
            data: formData,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            processData: false,
            contentType: false,
            success: function(data) {
              
               
               
               
            },
            error: function(data) {
                console.log(data);
            }
    });

}

function subirArchivos(){
  var op_plantilla = $('input:radio[name=plantilla]:checked').val();
  var archivo= document.getElementById("archivo");
  var niv_arch = $('#niv_arch').val();
  if(niv_arch==undefined && op_plantilla !='P'){
    niv_arch=0;
  }

 
  if(archivo.files && archivo.files[0]){
    var archivo_tarea= archivo.files[0];
  
  }else{
    var archivo_tarea="";
  }
   // var cod_respuesta= $('#cod_respuesta').val();
    var formData = new FormData();
   // formData.append('cod_respuesta', cod_respuesta);
    formData.append('archivo_tarea', archivo_tarea);
    formData.append('op_plantilla', op_plantilla);
    formData.append('niv_arch', niv_arch);
    $.ajax({
        url: '/subirArchivos',
        type: 'POST',              
        data: formData,
        enctype: 'multipart/form-data',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        processData: false,
        contentType: false,
        beforeSend: function(){
              
        },
        success: function(data)
        { 
            console.log(data['datos']);
            if(data.opcion=='no'){
                msg ='<ul>';
                for (var i in data.mensaje) {
                    msg +='<li>'+data.mensaje[i]+'</li>';
                }
                    
                msg += '</ul>';
                toastr.error(msg);
                 
                 
            }else{
                msg ='<ul>';
                //for (var i in data.mensaje) {
                    msg +='<li>'+data.mensaje+'</li>';
                //}
                msg += '</ul>';
                toastr.success(msg);
                var  nomb_archivo= data.archivo;
                registro='<tr><td   class="registro">'+data.archivo+'</td>';
                if(data['nsecundario'] !=null){
                    registro +='<td  >'+data['nsecundario'].nombre+'</td>';
                }else{
                    registro +='<td ></td>';
                }
                registro +='<td style="color:#FFFFFF" class="registro_prog">'+data.niv_arch+'</td>'+
                '<td width="15%"><a style="color:#FFFFFF" onclick="eliminarArchivo(\''+nomb_archivo+'\',\'\')" class="btn btn-danger btn_delete">'+
                '<i class="fas fa-trash"></i></a></td></tr>';
                $('#list_arch').append(registro);
                $("#archivo").val('');
                $('.btn_delete').off().click(function(e) {

                    $(this).parent('td').parent('tr').remove();
                 });

                tr = []; 
                temp = document.getElementsByClassName("registro"); 
                //console.log(temp);
                for(var i=0;i<temp.length;i++) 
                { 
                    tr.push(temp[i].innerText); 
                }
                //console.log(tr);
                /*oTable = $('#tbl_archivo').dataTable();

                var rows = oTable.fnGetNodes();

                for(rowIndex = 0; rowIndex < rows.length; rowIndex++) {
                    dataArr.push( $(rows[rowIndex]).find('td:eq(0)') );
                } */
            }
        },
        error: function(data)
        {   
            console.log(data);
        }
    });
}

function eliminarArchivo(nombre, resp_auto){
    var formData = new FormData();
    formData.append('nombre',nombre);
    formData.append('resp_auto',resp_auto);
     $.ajax({
            type: 'POST',
            url: '/eliminarArchivo',
            data: formData,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            processData: false,
            contentType: false,
            success: function(data) {
              //console.log(data);
              $(this).remove(); 
               
                    
            },
            error: function(data) {
                console.log(data);
            }
    });

}

function tblListRespAuto(){
   // var formData = new FormData();
   // formData.append('cod_campana',$('#cod_campana').val());
   $.ajax({
            type: 'GET',
            url: '/listaRespuesta',
            //data: formData,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            processData: false,
            contentType: false,
            success: function(data) {
                //console.log("DATA-->", data);
                $("#tblRespAuto").html(data);

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

function resetearFormulario(){
    
   $("#cod_respuesta").val('');
   $("#nombre").val('');
   $("#asunto").val('');
   $("input[name=plantilla]").prop("checked",false);
   $("#plantillaG").prop("checked",true);
   $("input[name=formPlantilla]").prop("checked",false);
   $('#tbl_archivo > tbody').empty();
   $('#mailing_programa').empty();
   $('#prog_arch').empty();

}

function editarFormulario(id){
    resetearFormulario();
    $('#tblBusqueda').removeClass('active');
    $('#tab-c1-0').removeClass('active');
    $('#respAutoTab').addClass('active');
    $('#tab_Formulario').addClass('active');

    var formData = new FormData();
    formData.append('id',id);
   
    $.ajax({
            type: 'POST',
            url: '/editarInfFormulario',
            data: formData,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            processData: false,
            contentType: false,
            success: function(data) {
                var niveles="";
                var cont =data['respAutoArchNivel2'].length - 1; 
                var cont2 =1; 
                for(i=0; i<data['respAutoArchNivel2'].length; i++){
                    
                    if(cont>=cont2){var coma=','}else{var coma='';}
                    niveles += data['respAutoArchNivel2'][i]['resp_auto_adj_nsecu_id']+coma;
                    cont2++;
                }
            var cod_resp_auto=data['respAuto']['id'];
           // console.log(data['respAutoProg'][0]['mailing_id']);
            $('#cod_respuesta').val(cod_resp_auto);
            $('#nombre').val(data['respAuto']['nombre']);
            $('#asunto').val(data['respAuto']['asunto']);
                if(data['respAuto']['resp_auto_tipo']=='G'){
                    $("#plantillaG").prop('checked', true);         
                    input ="<input id='mail' type='hidden'value='"+data['respAutoProg'][0]['mailing_id']+"'>";         
                    input  +="<input id='opPlantilla' type='hidden' value='"+data['respAuto']['resp_auto_tipo']+"'>";
                    $("#inputOculto").html(input);
                    tbl_plantilla ='<table style="width: 100%;" border="0">';
                    tbl_plantilla += '<tbody>';
                    for(var j=0; j<data['listMailing'].length; j++){
                        if(data['respAutoProg'][0]['mailing_id']==data['listMailing'][j]['id']){var select='checked';}else{var select='';}
                        tbl_plantilla +='<tr><br>'+
                        '<div class="custom-control custom-radio custom-control-inline">'+
                        '<input type="radio" id="mail'+data['listMailing'][j]['id']+'" name="mailing" '+select+' class="custom-control-input" value="'+data['listMailing'][j]['id']+'" >'+
                        '<label class="custom-control-label" for="mail'+data['listMailing'][j]['id']+'">'+data['listMailing'][j]['nombre']+'</label>'+
                        '</div>'+
                        '</tr>';
                    }
                    tbl_plantilla += '</tbody>'+
                    '</table>';





                 // $("#mail"+data['respAutoProg'][0]['mailing_id']).prop('checked', true);

                     $('#mailing_programa').html(tbl_plantilla);
                      $('.cmb_nivel2_multiple').select2({allowClear: true ,width: 'resolve' ,theme: "bootstrap", placeholder :' ' }); 

                }else{
                    console.log(data['listNivel2'].length);
                    $("#plantillaP").prop('checked', true);

                    var sel_prog='<div class="position-relative  form-group row">'+
                                    '<label for="exampleEmail" class="col-sm-12 col-form-label">Seleccionar el Programa para el archivo : </label>'+
                                    '<div class="col-sm-12">'+
                                    '<select id="niv_arch" name="niv_arch"  class="form-control sel_programa" >';
                        sel_prog +='<option value="">SELECCIONE..</option>';
                    for(var k =0; k<data['listNivel2'].length; k++){
                        sel_prog +='<option value="'+data['listNivel2'][k]['cod_nivel2']+'">'+data['listNivel2'][k]['nom_nivel2']+'</option>';
                    }
                    sel_prog += '</select>'+
                                '</div>'+
                                '</div>';   
                    $("#prog_arch").html(sel_prog);
                    $('#niv_arch').select2({width: 'resolve' ,theme: "bootstrap" });

                    


                        tbl_plantilla = '<table  style="width: 100%;" border="0"> <tbody id="mail_nivel2">';
                        var m =1;


                   // $("#prog_arch").html(data.html_programa);

                    for(var j=0; j<data['listMailing'].length; j++){
                        tbl_plantilla += '<tr>'+
                        '<td style="width: 30%;">'+data['listMailing'][j]['nom_mail']+'<br></td>'+
                        '<td style="width: 70%;"><br> <select id="'+m+'" name="'+m+'[]"  multiple="multiple" class="cmb_nivel2_multiple" >';
                            
                      
                        for(var k =0; k<data['listNivel2'].length; k++){
                           // cont++;
                            for(var l =0; l<data['respAutoProg'].length; l++){
                                var selected='';
                                if(data['listNivel2'][k]['cod_nivel2']==data['respAutoProg'][l]['nsecundario_id'] && data['respAutoProg'][l]['mailing_id']==data['listMailing'][j]['cod_mail']){
                                    var selected='selected';
                                    break;
                                }
                            }   
                              tbl_plantilla +=  '<option value="'+data['listNivel2'][k]['cod_nivel2']+'_'+data['listMailing'][j]['cod_mail']+'" '+selected+'>'+data['listNivel2'][k]['nom_nivel2']+'</option>';
                   

                        }
                        tbl_plantilla += '</select>'+
                       
                        '</td>'+

                        '</tr>';
                        m++;
                    }
                    $('.cmb_nivel2_multiple').select2({allowClear: true ,width: 'resolve' ,theme: "bootstrap" , placeholder :' '});
                    tbl_plantilla += '</tbody></table>';
                    tbl_plantilla +=  '<input type="hidden" id="cont_select" name="cont_select" value="'+m+'"> ';
                    //console.log(tbl_plantilla);
                    $('#mailing_programa').html(tbl_plantilla);
                }
                var registro='';
                for(var i=0; i<data['respAutoArch'].length; i++ ){
                    var nomb_archivo=data['respAutoArch'][i]['nombre'];
            registro +='<tr ><td class="registro">'+data['respAutoArch'][i]['nombre']+'</td>';

                for(var j=0; j<data['respAutoArchNivel2'].length; j++ ){
                    if(data['respAutoArch'][i]['id'] == data['respAutoArchNivel2'][j]['resp_auto_adj_id']){
                        if(data['respAutoArchNivel2'][j]['nombre_programa']==null){nom_prog=''}else{
                                nom_prog=data['respAutoArchNivel2'][j]['nombre_programa'];
                        }
                        registro +='<td>'+nom_prog+'</td>';

                        registro +='<td style="color:#FFFFFF"   class="registro_prog">'+data['respAutoArchNivel2'][j]['resp_auto_adj_nsecu_id'] +'</td>';
                    }
                }
            registro +='<td width="15%"><a style="color:#FFFFFF" onclick="eliminarArchivo(\''+nomb_archivo+'\','+cod_resp_auto+')" class="btn btn-danger btn_delete">'+
            '<i class="fas fa-trash"></i></a></td></tr>';
                    $('.cmb_nivel2_multiple').select2({allowClear: true ,width: 'resolve' ,theme: "bootstrap", placeholder :' ' }); 
                }



                 
            $('#list_arch').append(registro);
            $('.cmb_nivel2_multiple').select2({allowClear: true ,width: 'resolve' ,theme: "bootstrap", placeholder :' ' });
            $("#archivo").val('');
            $('.btn_delete').off().click(function(e) {

                $(this).parent('td').parent('tr').remove();
              });


                
                $("#plantilla"+data['respAuto']['formulario_id']).prop('checked', true);
         
                
               
            },
            error: function(data) {
                console.log(data);
            }
    });
}


function eliminarFormulario(id, nombre){
    var formData = new FormData();
  formData.append('cod_campana',id);
  $.confirm({
    title: 'Eliminar Respuesta Automática!',
    content: 'Desea realizar la eliminación de la respuesta automática ' + name + '?',
    buttons: {
        confirm: function () {
            $.ajax({
                type: 'POST',
                url: '/eliminarRespAutomatica',
                data: formData,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                processData: false,
                contentType: false,
                success: function (d) {
                    if (d['msg'] == 'error') {
                         toastr.error(d['data']);
                         tblListRespAuto();
                    } else {
                        toastr.success(d['data']);
                        tblListRespAuto();
                        
                    }
                },
                error: function (xhr) {
                    toastr.error('Error: '.xhr.statusText + xhr.responseText);
                },
            });

         },
        cancel: function () {
            $.alert('Se ha cancelado la eliminación!');
        }
    }
  });
}