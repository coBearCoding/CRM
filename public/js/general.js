$(document).ready(function()
{
    $.validator.addMethod('isMail', function(value, element, param) {
    if( /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test(value) ){
            // Hacer algo si el checkbox ha sido seleccionado
            return true;
        } else {
            // Hacer algo si el checkbox ha sido deseleccionado
            return false;
        }
    }, "Por favor, introduce una dirección de correo electrónico válida");
 
    $.validator.addMethod('isRuc', function(value, element, param) {
    var ruc = document.getElementById('txt_ruc').value;
    var ruc_parte =  ruc.substring(10, 13);
    if(ruc.length==13){
        if(ruc_parte=='001'){
            var cedula = ruc.substring(0, 10);
            validar_cedula(cedula); 
            return true; 
        }else{
         
            return false
        }
    }else{
         return false
        }
    }, "Por favor, introduce un Ruc Correcto");

     $.validator.addMethod('passConcuerde', function(value, element, param) {
        var pass = document.getElementById('password').value;
        var pass_confir = document.getElementById('password_confirmation').value;
        if(pass==pass_confir){
            return true
        }else{
             return false
        }
    }, "Las contraseñas no coinciden");
   
     $("#form").validate({
        ignore: [],
        rules: {
          'txt_email'          : {required: true,isMail:true},
          'txt_ruc'            : {required: true,number: true, isRuc:true},
          'email'              : {required: true,isMail:true},
          'password'          : {required: true,passConcuerde:true},
          'password_confirmation'          : {required: true,passConcuerde:true},
        },
        messages:{
          'txt_ruc':{
            number: "Por favor, ingresar numeros",
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


function validar_cedula(cedula){
     $('#validacion').html('');
    if(cedula.length == 10){
        var digito_region = cedula.substring(0,2);
        if( digito_region >= 1 && digito_region <=24 ){
          var ultimo_digito   =parseInt(cedula.substring(9,10));
          var pares = parseInt(cedula.substring(1,2)) + parseInt(cedula.substring(3,4)) + parseInt(cedula.substring(5,6)) + parseInt(cedula.substring(7,8));
          var numero1 = cedula.substring(0,1);
          var numero1 = (numero1 * 2);
          if( numero1 > 9 ){ var numero1 = (numero1 - 9); }
          var numero3 = cedula.substring(2,3);
          var numero3 = (numero3 * 2);
          if( numero3 > 9 ){ var numero3 = (numero3 - 9); }
          var numero5 = cedula.substring(4,5);
          var numero5 = (numero5 * 2);
          if( numero5 > 9 ){ var numero5 = (numero5 - 9); }
          var numero7 = cedula.substring(6,7);
          var numero7 = (numero7 * 2);
          if( numero7 > 9 ){ var numero7 = (numero7 - 9); }
          var numero9 = cedula.substring(8,9);
          var numero9 = (numero9 * 2);
          if( numero9 > 9 ){ var numero9 = (numero9 - 9); }
          var impares = numero1 + numero3 + numero5 + numero7 + numero9;
          var suma_total = (pares + impares);
          var primer_digito_suma = String(suma_total).substring(0,1);
          var decena = (parseInt(primer_digito_suma) + 1)  * 10;
          var digito_validador = decena - suma_total;
          if(digito_validador == 10)
            var digito_validador = 0;
          if(digito_validador == ultimo_digito){
            return true; 
          }else{
            return false; 
           
          }
          
        }else{
           return false; 
        }
     }else{
       return false; 
     }    
  
 }

function validaNumericos(event) {
    if ((event.charCode >= 48 && event.charCode <= 57)) {
        return true
    }
    return false;
}


