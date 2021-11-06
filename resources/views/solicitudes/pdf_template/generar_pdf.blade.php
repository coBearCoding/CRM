<html>
    <head>
        <style>
            .page-break {
                page-break-after: always;
            }
            body,html{
                color:#272727;
                font-family: Arial, Helvetica, sans-serif;
            }
            .mtable{
                font-size: 14px;
                text-align: center;
            }
            .tabla{
                border-collapse: collapse;
            }
            .tablao{
                border: 1px solid #ddd;
                height: 30px;background-color: #f5f5f5;
                font-size: 13px
            }
        </style>
    </head>
    <body>
        <div class="p-4 page-break">
            <table style="width: 100%;">
                <tr>
                    <td></td>
                    <td>C&oacute;digo:________________________ <br>Periodo: ________________________ <br>Fecha inicio: _____________________</td>
                    <td style="text-align:right;"><img src="{{$foto_url ?? ''}}" style="width: 100px;height: 100px;border: 3px solid #6B7E95;" /></td>
                </tr>
            </table>
            <br>
            <h2 style="text-align: center">SOLICITUD DE ADMISI&Oacute;N</h2>
            <br>
            <p style="text-align: left;"><strong>S&eacute; parte de la Universidad ECOTEC</strong></p>
            <p style="text-align: left;">Ya que vas a formar parte de esta gran familia, necesitamos conocer tus datos completos. A continuaci&oacute;n encontrar&aacute;s el formulario que deber&aacute;s llenar para nuestros registros</p>
                <p style="text-align: left;">!Gracias por tu colaboraci&oacute;n!</p>
                <br><br>
                <h3 style="text-align: left;color:white;background: #23559C;">1. DATOS PERSONALES</h3>

                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>No. de C&eacute;dula</strong></td>
                        <td class="tablao">{{$postulante->documento ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Nombres</strong></td>
                        <td class="tablao">{{$postulante->nombres ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Apellidos</strong></td>
                        <td class="tablao">{{$postulante->apellidos ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Sexo</strong></td>
                        @if ($postulante->sexo == 'F')
                        <td class="tablao">Femenino</td>
                        @else
                        <td class="tablao">Masculino</td>
                        @endif

                    </tr>
                    <tr>
                        <td class="tablao"><strong>Identificaci&oacute;n &Eacute;tnia</strong></td>
                        <td colspan="3" class="tablao">{{$postulante->etnia ?? ''}}</td>
                    </tr>
                </table>
                <br><br>
                <h3 style="text-align: left;color:white;background: #23559C;">2. DIRECCI&Oacute;N DOMICILIARIA</h3>
                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>Direcci&oacute;n de Domicilio</strong></td>
                        <td class="tablao">{{$postulante->direccion ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Provincia de residencia</strong></td>
                        <td class="tablao">{{$postulante->provincia ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Cant&oacute;n de residencia</strong></td>
                        <td class="tablao">{{$postulante->canton ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Sector</strong></td>
                        <td class="tablao">{{$postulante->sector ?? ''}}</td>
                    </tr>
                </table>
                <br><br>
                <h3 style="text-align: left;color:white;background: #23559C;">3. MEDIO DE CONTACTO</h3>
                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>Tel&eacute;fono</strong></td>
                        <td class="tablao">{{$postulante->telefono ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Celular</strong></td>
                        <td class="tablao">{{$postulante->celular ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Correo electr&oacute;nico</strong></td>
                        <td class="tablao">{{$postulante->email ?? ''}}</td>
                    </tr>
                </table>
                <br><br>
                <h3 style="text-align: left;color:white;background: #23559C;">4. FECHA DE NACIMIENTO</h3>
                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>Fecha Nacimiento</strong></td>
                        <td class="tablao">{{$postulante->fecha_nacimiento ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Pa&iacute;s de Nacimiento</strong></td>
                        <td class="tablao"></td>
                    </tr>
                </table>
                <br><br>
                <h3 style="text-align: left;color:white;background: #23559C;">5. ESTADO CIVIL</h3>
                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>Estado</strong></td>
                        <td class="tablao">{{$postulante->estado_civil ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>No. Personas N&uacute;cleo Familiar</strong></td>
                        <td class="tablao"></td>
                    </tr>
                </table>
                <br><br>
                <h3 style="text-align: left;color:white;background: #23559C;">6. COLEGIO EN QUE TE GRADUASTE</h3>
                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>Colegio</strong></td>
                        <td class="tablao">{{$postulante->institucion_nombre ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Tipo de Instituci&oacute;n</strong></td>
                        <td class="tablao">{{$postulante->tipo_institucion_nombre ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>A&ntilde;o de Graduaci&oacute;n</strong></td>
                        <td class="tablao">{{$postulante->graduacion ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Jornada</strong></td>
                        <td class="tablao">{{$postulante->jornada ?? ''}}</td>
                    </tr>
                </table>
                <br><br>
                <h3 style="text-align: left;color:white;background: #23559C;">7.¿HAS INICIADO ESTUDIO SUPERIORES EN OTRA INSTITUCI&Oacute;N?</h3>
                @if ($postulante->estudio_superior == 'SI')
                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>Tipo de Establecimiento</strong></td>
                        <td class="tablao">{{$postulante->estudio_tipo_institucion_nombre ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Provincia</strong></td>
                        <td class="tablao">{{$postulante->estudio_provincia ?? ''}} </td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Instituci&oacute;n</strong></td>
                        <td class="tablao">{{$postulante->estudio_institucion_nombre ?? ''}}</td>
                    </tr>
                </table>
                @else
                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>No</strong></td>
                    </tr>
                </table>
                @endif
                <br><br>
                <h3 style="text-align: left;color:white;background: #23559C;">8. POSEES ALGUNA DISCAPACIDAD</h3>
                @if ($postulante->discapacidad == 'SI')

                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>Discapacidad</strong></td>
                        <td class="tablao">{{$postulante->discapacidad ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>¿Cu&aacute;l?</strong></td>
                        <td class="tablao">{{$postulante->tipo_discapacidad ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Porcentaje</strong></td>
                        <td class="tablao">{{$postulante->porcentaje_discapacidad ?? ''}}</td>
                    </tr>
                </table>

                @else
                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>No</strong></td>
                    </tr>
                </table>
                @endif

                <br><br>
                <h3 style="text-align: left;color:white;background: #23559C;">9. LUGAR DE TRABAJO</h3>
                @if ($postulante->trabajando != NULL)
                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>Direcci&oacute;n</strong></td>
                        <td class="tablao">{{$postulante->direccion ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Ciudad</strong></td>
                        <td class="tablao">{{$postulante->ciudad ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Tel&eacute;fono</strong></td>
                        <td class="tablao">{{$postulante->telefono ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Cargo que Ocupas</strong></td>
                        <td class="tablao">{{$postulante->cargo ?? ''}}</td>
                    </tr>
                </table>
                @else
                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>No trabajo</strong></td>
                    </tr>
                </table>
                @endif

                <br><br>
                <h3 style="text-align: left;color:white;background: #23559C;">10. INFORMACI&Oacute;N ADICIONAL</h3>
                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>¿Se te ha otorgado alguna beca o descuento?</strong></td>
                        <td class="tablao">{{$postulante->beca ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>¿Por qu&eacute; escogiste la Universidad ECOTEC?</strong></td>
                        <td class="tablao">{{$postulante->porque_estudiaste ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>¿C&oacute;mo te enteraste de la existencia de la Universidad ECOTEC?</strong></td>
                        <td class="tablao">{{$postulante->enteraste ?? ''}}</td>
                    </tr>
                </table>
                <br><br>
                <h3 style="text-align: left;color:white;background: #23559C;">11. DATOS FAMILIARES</h3>
                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>Nombre del Padre</strong></td>
                        <td class="tablao">{{$postulante->nombre_padre ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Nivel de Educaci&oacute;n</strong></td>
                        <td class="tablao">{{$postulante->nivel_educacion_padre ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Domicilio</strong></td>
                        <td class="tablao">{{$postulante->direccion_padre ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Empresa</strong></td>
                        <td class="tablao">{{$postulante->empresa_padre ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Cargo</strong></td>
                        <td class="tablao">{{$postulante->cargo_padre ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Correo Electr&oacute;nico</strong></td>
                        <td class="tablao">{{$postulante->email_padre ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Tel&eacute;fono</strong></td>
                        <td class="tablao">{{$postulante->telefono_padre  ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"></td>
                        <td class="tablao"></td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Nombre de la Madre</strong></td>
                        <td class="tablao">{{$postulante->email_padre  ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Nivel de Educaci&oacute;n</strong></td>
                        <td class="tablao">{{$postulante->nivel_educacion_madre  ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Domicilio</strong></td>
                        <td class="tablao">{{$postulante->direccion_madre  ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Empresa</strong></td>
                        <td class="tablao">{{$postulante->empresa_madre  ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Cargo</strong></td>
                        <td class="tablao">{{$postulante->cargo_madre  ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Correo Electr&oacute;nico</strong></td>
                        <td class="tablao">{{$postulante->email_madre  ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Tel&eacute;fono</strong></td>
                        <td class="tablao">{{$postulante->telefono_madre  ?? ''}}</td>
                    </tr>
                    <tr><td></td><td></td></tr>
                    <tr>
                        <td class="tablao"><strong>No. de Hermanos</strong></td>
                        <td class="tablao">{{$postulante->cantidad_hermanos  ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>¿Qu&eacute; edades?</strong></td>
                        <td class="tablao">{{$postulante->edad_hermanos  ?? ''}}</td>
                    </tr>
                    <tr><td></td><td></td></tr>
                    <tr>
                        <td class="tablao"><strong>En caso de emergicia contactar a:</strong></td>
                        <td class="tablao">{{$postulante->emergencia  ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>No. celular en caso de emergencia</strong></td>
                        <td class="tablao">{{$postulante->celular  ?? ''}}</td>
                    </tr>
                </table>
                <br><br>
                <h3 style="text-align: left;color:white;background: #23559C;">12. ¿EN QU&Eacute; CARRERA EST&Aacute;S INTERESADO?</h3>
                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>Facultad</strong></td>
                        <td class="tablao">{{$postulante->facultad_nombre  ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>Carrera</strong></td>
                        <td class="tablao">{{$postulante->carrera_nombre  ?? ''}}</td>
                    </tr>
                    <tr>
                        <td class="tablao"><strong>&Eacute;nfasis</strong></td>
                        <td class="tablao">{{$postulante->enfasis_nombre  ?? ''}}</td>
                    </tr>
                </table>
                <br><br>
                <h3 style="text-align: left;color:white;background: #23559C;">13. MODALIDAD DE INGRESO</h3>
                <table style="width: 100%;" class="tabla">
                    <tr>
                        <td class="tablao"><strong>Modalidad</strong></td>
                        <td class="tablao">{{$postulante->modalidad_nombre  ?? ''}}</td>
                    </tr>
                </table>

                <h3 style="text-align: left;color:white;background: #23559C;">13. ENTREGA DE DOCUMENTOS INFORMATIVOS</h3>

                <p style="text-align:justify; "> Yo, {{$postulante->nombres  ?? ''}} {{$postulante->apellidos  ?? ''}}<strong></strong>
                postulante a la carrera de {{$postulante->carrera_nombre  ?? ''}}<strong></strong>, he recibido la informaci&oacute;n relacionada a los servicios, derecho y obligaciones como estudiante, as&iacute; como de las carreras que oferta la Universidad ECOTEC; Reglamento Interno y C&oacute;digo de &Eacute;tica; mi usuario y clave de acceso a la plataforma acad&eacute;mica y de gesti&oacute;n</p>
                <p>Fecha: {{date('Y-m-d')}}<strong> </strong></p>

                <p style="text-align: center;"><strong></strong><span style="font-weight: bold">{{$postulante->nombres ?? ''}} {{$postulante->apellidos ?? ''}}</span><br>______________________________</p>
                <p style="text-align: center;"><small><strong>Estudiante </strong></small></p>
                <p style="text-align: center;"><small><strong>CC. {{$postulante->documento  ?? ''}}</strong></small></p>

    </body>
</html>
