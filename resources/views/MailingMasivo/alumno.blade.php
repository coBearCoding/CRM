<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admisiones Educalinks</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        table, th, td {
          border-collapse: collapse;
          color: #5E809A;
          background: #f2f2f2;
        }
        th, td {
          
        }
        .cellpadding{
        }
        h1{
            margin: 0;;
        }
        a{text-decoration: none; }
        a.link{ color: 25b8e7; font-weight: 500;}
        a.button{ padding: 15px 20px; background: #0a5ca5; color: white; font-weight: 700; border-radius: 30px; transition: all 0.3s ease-in-out; }
        a.button:hover{ background-color: #25b8e7; color: #0a5ca5;  }
        p{font-size: 20px; }
        </style>
    
</head>
<body >
    <center>
<table width="600" style="font-family: montserrat, sanserif;" >
    <tr>
        <td class="cellpadding"> <br><br><img src="{{ env('APP_URL') }}/images/image-02.jpg" alt=""></td>
    </tr>
    <tr>
        <td><img src="/imagenes/notification-email-success.jpg" alt=""></td>
    </tr>
    <tr>
        <td class="cellpadding">
            <div style="padding: 0px 50px 0 50px;">
            <h1 style="color:#0a5ca5">Hola {{$solicitud->postulante->nombres}} {{$solicitud->postulante->apellidos}},</h1>
            
            <p>Estás por empezar tu carrera para cumplir tus objetivos y superar tus retos. <br>
                Te entregamos tus credenciales para que accedas al sistema académico de Ecotec
                <br>
                <br>
                <p><b>Tu código de Alumno:</b> {{$codigo}}</p>
                <p><b>Tu usuario:</b> {{$usuario}}</p>
                <p><b>Tu contraseña:</b> {{$password}}</p>
                <br>
                <p>Ahora podrás pagar el curso de nivelación, que tiene un valor de $330, si deseas pagarlo ahora da clic aquí</p>
                <br>
                <center>
                <a  href="https://atrium.ecotec.edu.ec/" class="button">Continuar con el proceso</a>
                </center>
                <br>
                <br>

            </p>
            </div>

        </td>
    </tr>
    <tr>
        <td></td>
    </tr>
    </tr>
</table>
</center>


</body>

</html>