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

        .subtitle-text{
            color: #0a5ca5;
            font-size: 1em;
            font-weight: 700;
        }

        </style>
    
</head>
<body >
    <center>
<table width="600" style="font-family: montserrat, sanserif;" >
    <tr>
        <td class="cellpadding" ><img src="{{ env('APP_URL') }}/images/email02.jpg"  alt=""></td>
    </tr>
    <tr>
        <td class="cellpadding">
            <div style="padding: 0px 50px 0 50px;">
            <h1  style="color:#0a5ca5">Hola {{$solicitud->postulante->nombres}} {{$solicitud->postulante->apellidos}},</h1>
            <p>Estamos contentos que te unas a la comunidad Ecotec. <br>
                Hemos revisado tu solicitud N° <b>{{$solicitud->cod_solicitud}}</b> y el estado de la documentación que nos has enviado se encuentra.
                <br>
                <br>
                <br>
                    <h1>Estado: <span class="subtitle-text">{{$estado}}</span></h1>
                <br>
                <br>
                @if($estado != 'Aprobada')
                    <br>
                    <h1>Motivo: <span class="subtitle-text">{{$motivo}}</span></h1>
                    <br>
                    <br>
                    <br>
                    <center>
                        <a  href="https://admisiones.ecotec.edu.ec/consultarSolicitud" class="button">Continuar con el proceso</a>
                    </center>
                    <br>
                @endif
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