$(document).ready(function()
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#cmb_campana').select2({theme: "bootstrap"});


    




});

function tblListaPlantilla(){
    
    //var formData = new FormData();
   
    $.ajax({
            type: 'POST',
            url: '/tblListaPlantilla',
            //data: formData,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            processData: false,
            contentType: false,
            success: function(data) {
                //console.log("DATA-->", data);
                $("#div_table").html(data);

                $('#tbl').DataTable({
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

function subirimagen(codigo){
    
    $('#ModalImagenes').modal({
        show:true,
        keyboard: true,
    });
              
}

function cerrarModal(){
  
   
    $("#ModalImagenes .close").click()
}


function ultimo_archivo(){

    $.ajax({
            type: 'GET',
            url: '/ultimo_archivo',
            processData: false,
            contentType: false,
            success: function(datos) {
                document.getElementById("contenido").innerHTML =datos; 
                var imagen_ruta = document.getElementById("contenido").innerHTML;
                document.getElementById('image-url').value = imagen_ruta;
                var id= $('#image-url').data('id');
                $('#'+id).attr('src', $('#image-url').val()) ;
                $('#'+id).attr('width', $('#image-w').val()) ;
                $('#'+id).attr('height', $('#image-h').val()) ;
                var link = $('#'+id).parent('a.link');  
                link.attr('href', $('#image-link-url').val()) ;
                $('a.link').click(function(e){
                    e.preventDefault();
                });
               
            },
            error: function(datos) {
                console.log(datos);
            }
        });
}

function Guardar(){
            var codigo= $('#codigo').val();
            
            var contenido_html  = $("#tosave").html();
            var titulo          = document.getElementById('titulo_plantilla').value;
            var cmb_campana          = document.getElementById('cmb_campana').value;
            //document.ftienda.action = "nueva-plantilla.php";
         
            document.ftienda.nombre.value = titulo;
            document.ftienda.contenido.value = contenido_html;
            document.ftienda.campana.value = cmb_campana;
            var e = "";
            $("#download-layout").html($("#tosave").html());
            var t = $("#download-layout");
            t.find(".preview, .configuration, .drag, .remove").remove();
            t.find("a.button-1").each(function () {
                $(this).attr('href', $(this).data('href'));
            });
            var clone = t.find('td#primary').parent().parent().parent();
    
            var preheader   = t.find('td#primary .lyrow .view .row table.preheader').parent().html();
            var header      = "";
            var body        = '';
            t.find('div.column .lyrow .view .row').each(function () {
                var self = $(this);
                body += self.html();
            });
            var contenido_export = body;
            document.ftienda.contenido_expo.value = contenido_export
            if(document.ftienda.nombre.value == ""){
                resultvalidacion = false;
                 document.getElementById('titulo_plantilla').focus();
                 toastr.error('Debe de ingresar el nombre de la plantilla');
                return;
            }else{
                var formData = new FormData();
                if(codigo !=undefined){ formData.append('codigo',codigo);}
                formData.append('cmb_campana',$('#campana').val()); 
                formData.append('nombre',$('#nombre').val()); 
                formData.append('contenido',$('#contenido').val()); 
                formData.append('contenido_expo',$('#contenido_expo').val()); 
                $.ajax({
                type: 'post',
                url: '/guardarPlantilla',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: formData,
                processData: false,
                contentType: false,
                success: function(datos) {
             
                    if(datos.clase=='error'){
                        if(datos.opcion=='validar'){
                          toastr.error(datos.mensaje.nombre);  
                        }
                        
                    }else{
                        toastr.success(datos.mensaje);
                    }
                   
                   
                },
                error: function(datos) {
                    console.log(datos);
                }
            });
        }
}

function eliminar(codigo, name){
  var formData = new FormData();
  formData.append('codigo',codigo);
  $.confirm({
    title: 'Eliminar Plantilla!',
    content: 'Desea realizar la eliminación de la plantilla ' + name + '?',
    buttons: {
        confirm: function () {
            $.ajax({
                type: 'POST',
                url: '/delete',
                data: formData,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                processData: false,
                contentType: false,
                success: function(data) {
                    tblListaPlantilla();
                     toastr.success(data+' '+name);

                },
                error: function(data) {
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

function preview(codigo){
  var formData = new FormData();
  formData.append('codigo',codigo);
  
    $.ajax({
        type: 'POST',
        url: '/preview',
        data: formData,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        processData: false,
        contentType: false,
        success: function(data) {
            if(data.archivo=='ok'){
                var formPreviewWindow = window.open(data.ruta, '_blank');
            }else{

               var formPreviewWindow = window.open('target', '_blank');
                formPreviewWindow.document.write(data.html); 
            }
            

        },
        error: function(data) {
            console.log(data);
                    

        }
    });
}

function editar(codigo){
    console.log(codigo);
    $('#codigo').val(codigo);
    $('#list_plantilla').removeClass('active');
    $('#list_plantilla-tab').removeClass('active');
    
    $('#create_plantilla-tab').addClass('active');
    $('#create_plantilla').addClass('show');
    $('#create_plantilla').addClass('active');
    $('#frm_plantilla').hide();
    $('#frm_plantilla_edit').show();
    $('#frmEditar').attr('src', "{{url('plantillaeditar')}}");
   
    // var site = url+'?toolbar=0&amp;navpanes=0&amp;scrollbar=0'
    ruta='<iframe src="plantillaeditar/'+codigo+'" id="frmEditar"  style="width: 100%;height: 950px;" ></iframe>';

    $('#frm_plantilla_edit').html(ruta);
      

}

function limpiarfrm(){
    document.getElementById('frmNuevo').contentWindow.location.reload(true);
    $('#frm_plantilla_edit').hide(); 
    $('#frm_plantilla').show();


}

