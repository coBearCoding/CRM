<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Events\CrmEvents;

Route::get('/', function () {

    return view('auth.login');
});

/*Route::get('/prueba','FormularioController@prueba')->name('prueba');*/


Route::get('verificar', function () { #verificar si me contecta a pusher
    return view('mailing.campos');
});

Route::get('prueba', function () { #verificar si me contecta a pusher
    #return Helper::postSendMail('Joel Ayala','egordillo@links.com.ec',144,'Jose Jose','Gracias por contactarnos');
    return Helper::getTemplates();
});


Auth::routes();

//Route::get('guardar_respuestas', 'FormularioController@guardar_respuestas')->name('guardar_respuestas');

//Route::get('/logout', 'DashboardController@logout')->name('logout');
/*Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    return view('auth.login');
});*/
Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('/dashboard/fuente-contacto', 'DashboardController@fuente_contacto')->name('fuente_contacto');
    Route::post('/dashboard/oferta-academica', 'DashboardController@oferta_academica')->name('oferta_academica');
    Route::post('/dashboard/oferta-academica-mes', 'DashboardController@oferta_academica_mes')->name('oferta_academica_mes');
    Route::post('/dashboard/estado-comercial', 'DashboardController@estado_comercial')->name('estado-comercial');
    Route::post('/dashboard/estado-comercial-mes', 'DashboardController@estado_comercial_mes')->name('estado-comercial-mes');
    Route::post('/dashboard/oferta', 'DashboardController@oferta')->name('oferta');
    Route::post('/dashboard/estado', 'DashboardController@estado')->name('estado');
    Route::post('/dashboard/detalle', 'DashboardController@detalle')->name('detalle');


    Route::name('admin.')->group(function () {
        Route::get('roles', 'RolesController@index')->name('roles')->middleware('configure');
        Route::get('usuario', 'Auth\RegisterController@index')->name('usuario')->middleware('configure');
        Route::get('empresas', 'EmpresaController@index')->name('empresas')->middleware('configure');
        Route::get('permisosrol', 'PermisosRolController@index')->name('permisosrol')->middleware('configure');
        Route::get('permisos', 'PermisosController@index')->name('permisos')->middleware('configure');
        Route::get('sedes', 'SedeController@index')->name('sedes')->middleware('configure');
    });

    //ROLES
    Route::post('/save_rol', 'RolesController@save')->name('save_rol')->middleware('configure');
    Route::post('/view_data_rol', 'RolesController@viewData')->name('view_data_rol')->middleware('configure');
    Route::post('/edit_rol', 'RolesController@edit')->name('edit_rol')->middleware('configure');
    Route::post('/delete_rol', 'RolesController@delete')->name('delete_rol')->middleware('configure');

    //USUARIOS
    Route::post('/view_data_usuarios', 'Auth\RegisterController@viewData')->name('view_data_usuarios')->middleware('configure');
    Route::post('/edit_user', 'Auth\RegisterController@edit')->name('edit_user')->middleware('configure');
    Route::post('/delete_user', 'Auth\RegisterController@delete')->name('delete_user')->middleware('configure');

    //EMPRESA
    Route::post('/view_data_entidad', 'EmpresaController@viewData')->name('view_data_entidad')->middleware('configure');
    Route::post('/save_empresa', 'EmpresaController@save')->name('save_empresa')->middleware('configure');
    Route::post('entidades', 'EmpresaController@UpdateorCreateEntidad')->name('entidades')->middleware('configure');

    //PERMISOS
    Route::post('/save_permisos', 'PermisosController@save')->name('save_permiso')->middleware('configure');
    Route::post('/view_data_permisos', 'PermisosController@viewData')->name('view_data_permiso')->middleware('configure');
    Route::post('/edit_permisos', 'PermisosController@edit')->name('edit_permiso')->middleware('configure');
    Route::post('/delete_permisos', 'PermisosController@delete')->name('delete_permiso')->middleware('configure');

    //PERMISOS_ROL
    Route::post('/save_permiso_rol', 'PermisosRolController@save')->name('save_permiso')->middleware('configure');
    Route::post('/view_data_permiso_rol', 'PermisosRolController@viewData')->name('view_data_permiso')->middleware('configure');
    Route::post('/edit_permiso_rol', 'PermisosRolController@edit')->name('edit_permiso')->middleware('configure');
    Route::post('/delete_permiso_rol', 'PermisosRolController@delete')->name('delete_permiso')->middleware('configure');

    //SEDES
    Route::post('/save_sede', 'SedeController@save')->name('save_sede')->middleware('configure');
    Route::post('/view_data_sede', 'SedeController@viewData')->name('view_data_sede')->middleware('configure');
    Route::post('/edit_sede', 'SedeController@edit')->name('edit_sede')->middleware('configure');
    Route::post('/delete_sede', 'SedeController@delete')->name('delete_sede')->middleware('configure');


    Route::post('/save_permisos_rol', 'PermisosRolController@edit')->name('save_permisos_rol')->middleware('configure');


    Route::name('config.')->group(function () {
        Route::get('fuentecontacto', 'FuentesContactoController@index')->name('fuentecontacto')->middleware('configure');
        Route::get('mediogestion', 'MediosContactoController@index')->name('mediogestion')->middleware('configure');
        Route::get('nivelprimario', 'NivelPrimarioController@index')->name('nivelprimario')->middleware('configure');
        Route::get('nivelsecundario', 'NivelSecundarioController@index')->name('nivelsecundario')->middleware('configure');
        Route::get('preguntasenc', 'PreguntasEncuestasController@index')->name('preguntasenc')->middleware('configure');
    });

    //FUENTES CONTACTO
    Route::post('/save_fcontacto', 'FuentesContactoController@save')->name('save_fcontacto')->middleware('configure');
    Route::post('/view_data_fcontacto', 'FuentesContactoController@viewData')->name('view_data_fcontacto')->middleware('configure');
    Route::post('/edit_fcontacto', 'FuentesContactoController@edit')->name('edit_fcontacto')->middleware('configure');
    Route::post('/delete_fcontacto', 'FuentesContactoController@delete')->name('delete_fcontacto')->middleware('configure');

    //FUENTES CONTACTO
    Route::post('/save_mgestion', 'MediosContactoController@save')->name('save_mgestion')->middleware('configure');
    Route::post('/view_data_mgestion', 'MediosContactoController@viewData')->name('view_data_mgestion')->middleware('configure');
    Route::post('/edit_mgestion', 'MediosContactoController@edit')->name('edit_mgestion')->middleware('configure');
    Route::post('/delete_mgestion', 'MediosContactoController@delete')->name('delete_mgestion')->middleware('configure');

    //NIVEL PRIMARIO
    Route::post('/save_nprimario', 'NivelPrimarioController@save')->name('save_nprimario')->middleware('configure');
    Route::post('/view_data_nprimario', 'NivelPrimarioController@viewData')->name('view_data_nprimario')->middleware('configure');
    Route::post('/edit_nprimario', 'NivelPrimarioController@edit')->name('edit_nprimario')->middleware('configure');
    Route::post('/delete_nprimario', 'NivelPrimarioController@delete')->name('delete_nprimario')->middleware('configure');

    //NIVEL SECUNDARIO
    Route::post('/save_nsecundario', 'NivelSecundarioController@save')->name('save_nsecundario')->middleware('configure');
    Route::post('/view_data_nsecundario', 'NivelSecundarioController@viewData')->name('view_data_nsecundario')->middleware('configure');
    Route::post('/edit_nsecundario', 'NivelSecundarioController@edit')->name('edit_nsecundario')->middleware('configure');
    Route::post('/delete_nsecundario', 'NivelSecundarioController@delete')->name('delete_nsecundario')->middleware('configure');

    //PREGUNTAS
    Route::post('/save_pregunta', 'PreguntasEncuestasController@save')->name('save_pregunta')->middleware('configure');
    Route::post('/view_data_pregunta', 'PreguntasEncuestasController@viewData')->name('view_data_pregunta')->middleware('configure');
    Route::post('/edit_pregunta', 'PreguntasEncuestasController@edit')->name('edit_pregunta')->middleware('configure');
    Route::post('/delete_pregunta', 'PreguntasEncuestasController@delete')->name('delete_pregunta')->middleware('configure');
     Route::post('/delete_leads','ContactosController@delete')->name('delete_leads')->middleware('configure');

    Route::name('gestion.')->group(function () {
        //INSERTAR RUTAS DE GESTION LEADS, CLIENTES
        Route::prefix('leads')->group(function () {
            Route::get('/', 'ContactosController@index')->name('leads')->middleware('configure');
            Route::post('/data-back', 'ContactosController@dataleads')->name('leads.data')->middleware('configure');
            Route::post('/data', 'ContactosController@leadsinfo')->name('leads.data')->middleware('configure');
            Route::post('/programa/oferta', 'ContactosController@ofertaByPrograma')->name('leads.ofertaByPrograma')->middleware('configure');
            Route::post('/post', 'ContactosController@postLeads')->name('leads.data')->middleware('configure');
            Route::post('/show', 'ContactosController@show')->name('leads.show')->middleware('configure');
            Route::post('/campana/programa', 'ContactosController@campanaPrograma')->name('leads.campana.programa')->middleware('configure');
            Route::post('/historial', 'ContactosController@historialLeads')->name('leads.historial')->middleware('configure');
            Route::post('/transaccional', 'ContactosController@sendTransaccional')->name('leads.email.transaccional')->middleware('configure');
            Route::post('/estado', 'ContactosController@estadoComercial')->name('leads.estado')->middleware('configure');
            Route::post('/seguimiento', 'ContactosController@seguimiento')->name('leads.seguimiento')->middleware('configure');
            Route::post('/seguimiento/show', 'ContactosController@seguimientoShow')->name('leads.seguimiento.show')->middleware('configure');
            Route::post('/auditoria', 'ContactosController@showAuditoria')->name('leads.auditoria')->middleware('configure');
            Route::post('/llamada', 'ContactosController@llamada')->name('llamada');
            Route::post('/llamada/conectar', 'ContactosController@SingleSingOnElastix')->name('llamada');
            Route::post('/llamada/entrante', 'ContactosController@llamadaEntrante')->name('llamada.entrante');
            Route::post('/oferta/campana', 'ContactosController@campanaByoffers')->name('campanaByoffers');
            Route::post('/preguntas', 'ContactosController@preguntas')->name('preguntas');
            Route::post('/preguntas/post', 'ContactosController@preguntasPost')->name('preguntas.post');
            Route::get('/html/{templateId}', 'MailingController@htmlView')->name('preguntas.post');
            Route::post('/registro','ContactosController@registro_auditoria')->name('registro');
            Route::post('/edit','ContactosController@editContacto')->name('editContacto');
        });

        Route::prefix('clientes')->group(function () {
            Route::get('/', 'ContactosController@indexclientes')->name('clientes')->middleware('configure');
            Route::post('/data', 'ContactosController@dataclientes')->name('clientes.data')->middleware('configure');
        });

        Route::prefix('tareas')->group(function () {
            Route::get('/', 'TareasController@index')->name('tareas')->middleware('configure');
            Route::get('/data', 'TareasController@data')->name('tareas.data')->middleware('configure');
        });

        Route::prefix('calendar')->group(function () {
            Route::get('/', 'CalendarController@index')->name('calendar')->middleware('configure');
            Route::get('/data', 'ClientesController@data')->name('calendar.data')->middleware('configure');
        });

        Route::prefix('metas')->group(function () {
            Route::get('/', 'MetasController@index')->name('metas')->middleware('configure');
            Route::post('/save_metas', 'MetasController@save')->name('metas.save')->middleware('configure');
            Route::post('/view_data_metas', 'MetasController@viewData')->name('metas.data')->middleware('configure');
            Route::post('/edit_metas', 'MetasController@edit')->name('metas.edit')->middleware('configure');
            Route::post('/delete_metas', 'MetasController@delete')->name('metas.delete')->middleware('configure');
        });
    });
    Route::name('mkt.')->group(function () {


        Route::get("viewListaCampania", "CampaniaController@viewListaCampania")->name('viewListaCampania')->middleware('configure');
        Route::post("tblListaCampania", "CampaniaController@tblListaCampania")->name('tblListaCampania')->middleware('configure');
        Route::get("formularioCampana", "CampaniaController@formularioCampana")->name('formularioCampana')->middleware('configure');
        Route::post("cmbNivel2", "CampaniaController@cmbNivel2")->name('cmbNivel2')->middleware('configure');
        Route::post("nsecundario", "CampaniaController@nsecundario")->name('nsecundario')->middleware('configure');
        Route::post("nuevaCampana", "CampaniaController@nuevaCampana")->name('nuevaCampana')->middleware('configure');
        Route::post("formularioCampanaEditar", "CampaniaController@formularioCampanaEditar")->name('formularioCampanaEditar')->middleware('configure');
        Route::post("eliminarCampana", "CampaniaController@eliminarCampana")->name('eliminarCampana')->middleware('configure');
        Route::post("cmbAsesor", "CampaniaController@cmbAsesor")->name('cmbAsesor')->middleware('configure');
        Route::get("importar", "ImportarController@importar")->name('importar')->middleware('configure');
        Route::post("cmbNivelImportar2", "ImportarController@cmbNivelImportar2")->name('cmbNivelImportar2')->middleware('configure');
        Route::get('respuestaAutomatica', 'RespuestaAutomaticaController@index')->name('respuestaAutomatica')->middleware('configure');
        Route::get('wizardFormRespAuto', 'RespuestaAutomaticaController@wizardFormRespAuto')->name('wizardFormRespAuto')->middleware('configure');
        Route::get('listaRespuesta', 'RespuestaAutomaticaController@listaRespuesta')->name('listaRespuesta')->middleware('configure');

        // Route::post('datosSeleccionFormulario', 'RespuestaAutomaticaController@datosSeleccionFormulario')->name('datosSeleccionFormulario')->middleware('configure');
        Route::post("cmbProgramas", "ImportarController@cmbProgramas")->name('cmbPrograma')->middleware('configure');
        Route::post('cmbCampana', 'ImportarController@cmbCampana')->name('cmbCampana')->middleware('configure');
        Route::post('cmbAsesor_campana', 'ImportarController@cmbAsesor_campana')->name('cmbAsesor_campana')->middleware('configure');

        Route::post('datosGuardado', 'RespuestaAutomaticaController@datosGuardado')->name('datosGuardado')->middleware('configure');
        Route::post('guardarNsecundario', 'RespuestaAutomaticaController@guardarNsecundario')->name('guardarNsecundario')->middleware('configure');
        Route::get('formulario', 'FormularioController@index')->name('formulario')->middleware('configure');
        Route::post('/delete_formulario', 'FormularioController@delete')->name('delete_formulario')->middleware('configure');
        Route::post('editarInfFormulario', 'RespuestaAutomaticaController@editarInfFormulario')->name('editarInfFormulario')->middleware('configure');
        Route::post('opcionPlantilla', 'RespuestaAutomaticaController@opcionPlantilla')->name('opcionPlantilla')->middleware('configure');
        Route::post('eliminarRespAutomatica', 'RespuestaAutomaticaController@eliminarRespAutomatica')->name('eliminarRespAutomatica')->middleware('configure');


        Route::get('/plantilla', 'PlantillasController@index')->name('plantilla')->middleware('configure');
        Route::get('/plantillavista', 'PlantillasController@plantilla')->name('plantillavista')->middleware('configure');
        Route::post('/imagen_archivo', 'PlantillasController@imagen_archivo')->name('imagen_archivo')->middleware('configure');
        Route::get('/ultimo_archivo', 'PlantillasController@ultimo_archivo')->name('ultimo_archivo')->middleware('configure');
        Route::post('/guardarPlantilla', 'PlantillasController@guardarPlantilla')->name('guardarPlantilla')->middleware('configure');
        Route::post('/tblListaPlantilla', 'PlantillasController@tblListaPlantilla')->name('tblListaPlantilla')->middleware('configure');
        Route::post('/delete', 'PlantillasController@delete')->name('delete')->middleware('configure');
        Route::post('/preview', 'PlantillasController@preview')->name('preview')->middleware('configure');
        Route::get('/plantillaeditar/{codigo}', 'PlantillasController@plantillaeditar')->name('plantillaeditar')->middleware('configure');

        Route::get("/mailing", "MailingController@index")->name('mailing')->middleware('configure');
        Route::post("/mailing/template", "MailingController@template")->name('mailing.template')->middleware('configure');
        Route::post("/mailing/import", "MailingController@sendMailing")->name('mailing.import')->middleware('configure');

        Route::get('/mailing/excel', function () {
            $mail = 'mailing.xlsx';
            $path = public_path() . "/files/" . $mail;
            return response()->download($path, $mail, [
                'Content-Type' => 'application/vnd.ms-excel',
                'Content-Disposition' => 'inline; filename="' . $mail . '"'
            ]);

        })->name('mailing.plantilla');


    });


    Route::post('/save_form', 'FormularioController@save')->name('save_form')->middleware('configure');
    Route::post('/view_data_form', 'FormularioController@viewData')->name('view_data_form')->middleware('configure');
    Route::post('/edit_form', 'FormularioController@edit')->name('edit_form')->middleware('configure');
    Route::post('/delete_form', 'FormularioController@delete')->name('delete_form')->middleware('configure');
    Route::post('/view_form_n2', 'FormularioController@viewNivel2')->name('view_form_n2')->middleware('configure');

    Route::post('/save_plantilla', 'PlantillasController@save')->name('save_plantilla')->middleware('configure');
    Route::post('/view_data_plantilla', 'PlantillasController@viewData')->name('view_data_plantilla')->middleware('configure');
    Route::post('/edit_plantilla', 'PlantillasController@edit')->name('edit_plantilla')->middleware('configure');
    Route::post('/delete_plantilla', 'PlantillasController@delete')->name('delete_plantilla')->middleware('configure');


    Route::name('reporte.')->group(function () {

        Route::get('sistema', 'FormularioController@index')->name('sistema')->middleware('configure');


        Route::get('exportarRoles', 'ReporteController@exportRol')->name('exportarRoles')->middleware('configure');
        Route::get('imprimirRoles', 'ReporteController@imprimirRol')->name('imprimirRoles')->middleware('configure');

        Route::get('gestion', 'GestionController@index')->name('gestion')->middleware('configure');
        Route::post('reporte', 'GestionController@reporte')->name('tipo')->middleware('configure');
        Route::post('reporte/contacto', 'GestionController@contacto')->name('contacto')->middleware('configure');
        Route::post('estado', 'GestionController@rptEstadoComercial')->name('estado')->middleware('configure');
        Route::post('fuente-contacto', 'GestionController@rptFuenteContactoEstado')->name('fuentecontacto')->middleware('configure');
        Route::post('nivel-secundario-datos', 'GestionController@loadNSecundario')->name('nivelsecundario')->middleware('configure');
        Route::get('llamadas', 'LlamadasController@index')->name('llamadas')->middleware('configure');
        Route::post('llamadas_nivel', 'LlamadasController@nivel')->name('llamadas_nivel')->middleware('configure');
        Route::post('llamadas_asesor', 'LlamadasController@asesor')->name('llamadas_asesor')->middleware('configure');
        Route::post('reporte/llamadas_reporte', 'LlamadasController@reporte')->name('llamadas_reporte')->middleware('configure');
    });
    Route::post("importarDatos", "ImportarController@importarDatos")->name('importarDatos')->middleware('configure');


    Route::post("subirArchivos", "RespuestaAutomaticaController@subirArchivos")->name('subirArchivos');
    Route::post("eliminarArchivo", "RespuestaAutomaticaController@eliminarArchivo")->name('eliminarArchivo');
    Route::post("datosEnviados", "RespuestaAutomaticaController@datosEnviados")->name('datosEnviados');
    //descargar la plantilla de Leads
    Route::get('/downLeads', function () {
        $filename = 'Leads.xlsx';
        $path = public_path() . "/files/" . $filename;
        return response()->download($path, $filename, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);

    })->name('downLeads');
    Route::get('/downClientes', function () {
        $filename = 'Clientes.xlsx';
        $path = public_path() . "/files/" . $filename;
        return response()->download($path, $filename, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);

    })->name('downClientes');

    Route::post('notificaciones', 'NotificacionesController@index')->name('notificaciones');

});

Route::get('guardar_respuestas', 'FormularioController@guardar_respuestas')->name('guardar_respuestas');
#Route::get('llamada', 'ContactosController@llamada')->name('llamada');

###################### S O L I C I T U D E S #########################
Route::name('horario.')->middleware('auth')->group(function () {
    Route::prefix('horario')->group(function () {
        Route::get('/', 'HorarioController@index')->name('index');
        Route::post('/data', 'HorarioController@data')->name('data');
        Route::post('/register', 'HorarioController@register')->name('register');
        Route::post('/delete', 'HorarioController@delete')->name('delete');
        Route::post('/detalle', 'HorarioController@detalle')->name('detalle');
    });
});

Route::name('solicitud.')->middleware('auth')->group(function () {
    Route::prefix('solicitudes')->group(function () {
        Route::get('/', 'SolicitudController@index')->name('index');
        Route::post('/data', 'SolicitudController@data')->name('data');
        Route::post('/register', 'SolicitudController@register')->name('register');
        Route::post('/delete', 'SolicitudController@delete')->name('delete');
        Route::post('/detalle', 'SolicitudController@detalle')->name('detalle');
        Route::post('/estado', 'SolicitudController@estado')->name('estado');
        Route::post('/reporte', 'SolicitudController@reporte')->name('reporte');
        Route::get('/pdf/{id_solicitud}/{cod_solicitud}', 'SolicitudController@pdf')->name('pdf');
        Route::post('historial', 'SolicitudController@historial')->name('historial');
        Route::post('documento', 'SolicitudController@documentos')->name('documento');
        Route::post('aprobar-rechazar', 'SolicitudController@aprobarRechazar')->name('documento.aprobarRechazar');
        Route::post('aplicar-cambios', 'SolicitudController@aplicarCambios')->name('documento.aprobarRechazar');
        Route::post('migrar', 'SolicitudController@descargarDocumento')->name('migrar');
        Route::get('descargar/{id_documento}', 'SolicitudController@descargarDocumento')->name('descargar');
    });
});

Route::name('documento.')->middleware('auth')->group(function () {
    Route::prefix('documentos')->group(function () {
        Route::get('/', 'DocumentoController@index')->name('index');
        Route::post('/data', 'DocumentoController@data')->name('data');
        Route::post('/register', 'DocumentoController@register')->name('register');
        Route::post('/delete', 'DocumentoController@delete')->name('delete');
        Route::post('/detalle', 'DocumentoController@detalle')->name('detalle');
    });
});

###################### S O L I C I T U D E S #########################


