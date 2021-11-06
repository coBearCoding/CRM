var url_tokem = document.getElementById('xurl_socket').value;
//var url_tokem = 'http://crm.ecotec.edu.ec:5000';
var options = {
          rememberUpgrade:true,
          transports: ['websocket'],
          secure:true, 
          rejectUnauthorized: false
              }
var socket = io.connect(url_tokem,options); /*IP O URL DONDE ESTA EL SERVIDOR DE SOCKET*/

//verificar la conexion
socket.on('connect', function() {
    console.log('Conectado al servidor');
    //document.getElementById("status").innerHTML = "";
   	//document.getElementById("status").innerHTML = '<i class="fa fa-circle" style="color: green" aria-hidden="true" id="statusElastix"></i> Conectado';
    UsuarioConfig(document.getElementById('nameUser').value,document.getElementById('extUser').value);
   calls();
});

// escuchar si se desconecto
socket.on('disconnect', function() {
    console.log('Perdimos conexión con el servidor');
   	//showCall(false);
   	//document.getElementById("status").innerHTML = "";
   	//document.getElementById("status").innerHTML = '<i class="fa fa-circle" style="color: red" aria-hidden="true" id="statusElastix"></i> Desconectado';
});



function calls(){
  // Escuchar información
  socket.on('calls', function(mensaje) {
    console.log(mensaje);
    if(mensaje.type == 1){ //llamada entrante
      showCall(true);
      document.getElementById("bellNotificationCall").classList.add("bellNotification");
      document.getElementById("callsColorTitle").style.background = "#04a1f4";
       $("#callsColorTitle").css('border-radius','20px 20px 0px 0px');
      document.getElementById('closeToolbar').innerHTML = '';
      document.getElementById("numberCalls").innerHTML = "";
      document.getElementById("numberCalls").innerHTML = mensaje.number;
      document.getElementById("callsTitle").innerHTML = "";
      document.getElementById("callsTitle").innerHTML = "Llamada Entrante...";
      document.getElementById('closeToolbar').innerHTML = '<i class="fa fa-times" aria-hidden="true" id="closeCalls" onclick="hideCalls()"></i>';
      verificarCliente(mensaje.number,"Entrante");
    }else if(mensaje.type == 2){ //llamada contestada
      showCall(true);
      document.getElementById('closeToolbar').innerHTML = '';
      document.getElementById("callsColorTitle").style.background = "#1cb71b";
       $("#callsColorTitle").css('border-radius','20px 20px 0px 0px');
      document.getElementById("bellNotificationCall").classList.remove("bellNotification");
      document.getElementById("numberCalls").innerHTML = "";
      document.getElementById("numberCalls").innerHTML = mensaje.number;
      document.getElementById("callsTitle").innerHTML = "";
      document.getElementById("callsTitle").innerHTML = "Llamada en Progreso...";
      verificarCliente(mensaje.number,"Contestada");
      //empezarDetener();
    }else if(mensaje.type == 3){ //llamada termianda satisfactoria
      localStorage.removeItem("inicio");
      showCall(true);
      document.getElementById("id_call").value = mensaje.id_call;
      document.getElementById('closeToolbar').innerHTML = '<i class="fa fa-times" aria-hidden="true" id="closeCalls" onclick="hideCalls()"></i>'; 
      $("#callsColorTitle").css('background','#fecd2f');
      $("#callsColorTitle").css('border-radius','20px 20px 0px 0px');
      $("#bellNotificationCall").removeClass('bellNotification');
      $("#numberCalls").html('');
      $("#numberCalls").html(mensaje.number);
      $("#callsTitle").html('');
      $("#callsTitle").html('Llamada Terminada');
      //llamadas_registrar(mensaje.number,"Terminada");
    }else if(mensaje.type == 4){ //llamada perdida
      verificarCliente(mensaje.number,"Perdida");
      showCall(true);
      document.getElementById('closeToolbar').innerHTML = '<i class="fa fa-times" aria-hidden="true" id="closeCalls" onclick="hideCalls()"></i>'; 
      $("#callsColorTitle").css('background','#c9181f');
      $("#callsColorTitle").css('border-radius','20px 20px 0px 0px');
      $("#bellNotificationCall").removeClass('bellNotification');
      $("#numberCalls").html('');
      $("#numberCalls").html(mensaje.number);
      $("#callsTitle").html('');
      $("#callsTitle").html('Llamada Perdida');
    }

  });
}

function UsuarioConfig(user,ext){
	socket.emit('configurarUsuario', {
	    nombre: user,
	    ext: ext
	}, function(resp) {
	    console.log('respuesta: ', resp);
	});
}

function hideCalls(){
  document.getElementById('alertCall').style.display = "none";
}


function showCall(flag){
  if(flag){
    document.getElementById("alertCall").style.display = "block";
    document.getElementById("alertCall").classList.add("animated");
    document.getElementById("alertCall").classList.add("fadeInUp");
    document.getElementById("alertCall").classList.add("slower");
  }else{
    document.getElementById("alertCall").style.display = "none";
  }
}

function verificarCliente(telefono,type)
{  

  var data = new FormData();  
  data.append('telefono', telefono);
  data.append('tipo', type);
  data.append('_token', $('meta[name="csrf-token"]').attr('content'));
  var xhr = new XMLHttpRequest();
  xhr.open('POST', '/leads/llamada/entrante' , true);
  xhr.send(data);
  xhr.onreadystatechange=function(){
    if (xhr.readyState==4 && xhr.status==200)
    { 
      /*if(xhr.responseText.split('/')[1] != ""){
        var resp = xhr.responseText;
        console.log
        if (xhr.responseText.split('/')[2] =="clientes") {
          document.getElementById('tabla').value = "clientes";
          document.getElementById('links_user').setAttribute('href', '/administrador/mod-clientes.php?cod_cliente='+resp.split('/')[1]);
          document.getElementById('nameCalls').innerHTML = '<a target="_blank" title="Mostrar información" href="/administrador/mod-clientes.php?cod_cliente='+resp.split('/')[1]+'">'+resp.split('/')[0].substring(0, 10)+'... </a>';
          document.getElementById('name_users').value = resp.split('/')[0];
          document.getElementById('id_name_users').value = resp.split('/')[1];
          llamadas_registrar(telefono,type);
          document.getElementById('Tarea').setAttribute('href', '/administrador/nueva-tarea.php?task='+resp.split('/')[0]);

        }else{
          document.getElementById('tabla').value = "leads";
          document.getElementById('links_user').setAttribute('href', '/administrador/mod-leads.php?cod_lead='+resp.split('/')[1]);
          document.getElementById('nameCalls').innerHTML = '<a target="_blank" title="Mostrar información" href="/administrador/mod-leads.php?cod_lead='+resp.split('/')[1]+'">'+resp.split('/')[0].substring(0, 10)+'...</a>';
          document.getElementById('name_users').value = resp.split('/')[0];
          document.getElementById('id_name_users').value = resp.split('/')[1];
          document.getElementById('Tarea').setAttribute('href', '/administrador/nueva-tarea.php?task='+resp.split('/')[0]);
          llamadas_registrar(telefono,type);
        }
      }else{
          document.getElementById('links_user').setAttribute('href', '/administrador/nuevo-leads.php?number='+telefono);
          document.getElementById('nameCalls').innerHTML = '<a target="_blank" title="Añadir cliente" href="/administrador/nuevo-leads.php?number='+telefono+'">Desconocido</a>';
          document.getElementById('name_users').value = 'Desconocido';
          document.getElementById('id_name_users').value = 0;
          document.getElementById('tabla').value = '';
          document.getElementById('Tarea').setAttribute('href', '/administrador/nueva-tarea.php');
          llamadas_registrar(telefono,type);
      }*/
      console.log(xhr.responseText);
      datos = JSON.parse(xhr.responseText);
      document.getElementById('tabla').value = datos.tipo;
      document.getElementById('nameCalls').innerHTML = '<a target="_blank" title="Mostrar información" href="/leads">'+datos.nombre.substring(0, 15)+'... </a>';
      document.getElementById('name_users').value = datos.nombre;
      document.getElementById('id_name_users').value = datos.id;
      




    } 
  }
}


function autoupdate() {
  setTimeout(function(){
     $('.bellNotification').addClass('botonF1_actice');
     setTimeout(function(){
        $('.bellNotification').removeClass('botonF1_actice');
        setTimeout(autoupdate, 500);
     }, 500)
  }, 200)
}


