<?php

namespace App\Http\Controllers;

use App\Campana;
use App\CampanasProgramas;
use App\ContactoGeneral;
use App\Formulario;
use App\Events\CrmEvents;
use App\FuentesContacto;
use App\Mail\PlantillaGeneral;
use App\NivelPrimario;
use App\NivelSecundario;
use App\Contacto;
use App\User;
use App\Parametro;
use App\PermisosNPrimario;
use App\Profile;
use App\TipoContacto;
use App\ContactoHistorico;
use App\RespuestaAutomaticaNsecundario;
use App\RespuestaAutomaticaAdjunto;
use App\CampanasUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PlantillaFormulario;
use App\AuditoriaContacto;

use App\Helpers\Helper;

class FormularioController extends Controller
{


    public function index()
    {
        $lstFuentes = FuentesContacto::where('estado', 'A')->orderBy('id', 'asc')->get();
        $paramUrl = Parametro::where('id', 3)->first();
        $objinfoUser = Session::get('infoUser');
        $lstDatos = Campana::where('estado', 'A')->where('empresa_id', $objinfoUser->empresa_id)->get();
        return view('formulario.index', compact('lstDatos', 'lstFuentes', 'paramUrl'));
    }

    public function viewData(Request $request)
    {
        $objinfoUser = Session::get('infoUser');
        $lstResult = Formulario::where('empresa_id', $objinfoUser->empresa_id)->with('campana')->get();
        return view('formulario.tabla', compact('lstResult'));
    }

    public function save(Request $request)
    {
        try {
            $objinfoUser = Session::get('infoUser');

            if (!empty($request->hide_id)) {
                $messages = [
                    'txt_nombre.required' => 'Ingrese Nombre',
                    'campana_id.required' => 'Ingrese Campaña'
                ];

                $validator = Validator::make($request->all(), [
                    'txt_nombre' => 'required|max:150|unique:formularios,nombre,' . $request->hide_id . ',id',
                    'campana_id' => 'required'
                ], $messages);

                if ($validator->fails()) {
                    $mensaje = '';
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $obj = Formulario::find($request->hide_id);
                    $obj->nombre = $request->txt_nombre;
                    $obj->campana_id = $request->campana_id;
                    $obj->estado = 'A';
                    $obj->empresa_id = $objinfoUser->empresa_id;
                    $obj->user_id = Auth::user()->id;
                    $obj->html_texto = $request->html;
                    $obj->json_texto = $request->json;
                    $obj->save();

                    return response()->json(['msg' => 'success', 'data' => 'Se ha actualizado correctamente: ' . $request->txt_nombre]);
                }
            } else {
                $messages = [
                    'txt_nombre.required' => 'Ingrese Nombre',
                    'campana_id.required' => 'Ingrese Campaña'
                ];

                $validator = Validator::make($request->all(), [
                    'txt_nombre' => 'required|max:50|unique:formularios,nombre',
                ], $messages);

                if ($validator->fails()) {
                    $mensaje = '';
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $obj = new Formulario();
                    $obj->nombre = $request->txt_nombre;
                    $obj->campana_id = $request->campana_id;
                    $obj->estado = 'A';
                    $obj->empresa_id = $objinfoUser->empresa_id;
                    $obj->user_id = Auth::user()->id;
                    $obj->html_texto = $request->html;
                    $obj->json_texto = $request->json;
                    $obj->save();

                    return response()->json(['msg' => 'success', 'data' => 'Se ha guardado correctamente: ' . $request->txt_nombre]);
                }
            }


        } catch (Exception $e) {
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $obj = Formulario::find($request->id);
            $obj->estado = 'I';
            $obj->save();
            return ['msg' => 'success', 'data' => 'Se ha desactivado correctamente: ' . $obj->nombre];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }

    public function edit(Request $request)
    {
        try {
            $obj = Formulario::find($request->id);
            return ['msg' => 'success', 'info' => 'Se ha cargado información: ' . $obj->nombre, 'data' => $obj];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }

    public function viewNivel2(Request $request)
    {
        $lstResult = CampanasProgramas::with('programa')->with('campana')
            ->where('campana_id', $request->id)->get();
        return view('formulario.nivel2', compact('lstResult'));
    }

    public function guardar_respuestas(Request $request)
    {
        $inputs = $request->all();

        $nombre = $request->nombre ?? '';
        $correo = $request->correo ?? '';
        $telefono = $request->telefono ?? '';
        $prog_id = $request->prog_id ?? '';
        $form_id = $request->form_id ?? '';
        $fte_contacto = $request->fte_contacto ?? '';

        if (empty($nombre) || empty($correo) || empty($telefono)) {
            return view('mailing.campos');
        }

        if (isset($request->ciudad)) {
            $direccion = $request->ciudad;
        } else {
            $direccion = null;
        }

        if (isset($request->plataform)) {
            $plataform = $request->plataform;
        } else {
            $plataform = null;
        }

        if (!empty($plataform)) {
            if ($plataform == 'fb') {
                $result = FuentesContacto::where('nombre', 'Facebook')->first();
                $fte_contacto = $result->id;
            } else {
                if ($plataform == 'ig') {
                    $result = FuentesContacto::where('nombre', 'Instagram')->first();
                    $fte_contacto = $result->id;
                }
            }
        }

      //  return $request;

        try {
            DB::beginTransaction();
            $telf_leads = Helper::phone($telefono);
            $leads = Contacto::where('correo', 'LIKE', '%' . $request->correo . '%')->Orwhere('telefono', 'LIKE', '%' . $telf_leads . '%')->where('estado', 'A')->first();

            if ($request->form_id > 0) {
                $campana = Formulario::find($request->form_id);

                $campana_id = $campana->campana_id;
                $form_id = $request->form_id;
            } else {
                $campana = Campana::find($request->campana_id);
                $form = Formulario::where('campana_id', $request->campana_id)->first();

                if(!empty($form)){
                    $form_id = $form->id;
                }else{
                    $form_id = 0;
                }

                 $campana_id = $campana->id;
            }

                $campana = Campana::find($campana_id);


            $campana_programa = CampanasProgramas::where('nsecundario_id', $prog_id)->where('campana_id', $campana_id)->first();

            $nombre_asesor = '';
            $telf_asesor = '';
            $email_asesor = '';

            /* $asesor = DB::selectOne('SELECT cu.user_id, count(distinct ch.contacto_tipo_id) leads , u.id, u.name, u.email, u.status, p.celular as telefono
                                    FROM campana_users cu
                                           left join contacto_historicos ch on ch.vendedor_id = cu.user_id
                                           join campana c on  c.id = cu.campana_id and c.id = :campana
                                           join users u on u.id = cu.user_id
                                           join profiles p on p.user_id = u.id
                                           left join estado_comercial ec on ec.id= ch.estado_comercial_id and ch.estado_comercial_id in (SELECT id FROM estado_comercial where id not in (2,5,7,8))
                                    where c.estado = :estado and cu.estado=:estado_a
                                    group by cu.user_id,  u.id, u.name, u.email, u.status, p.celular
                                    order by count(distinct ch.contacto_tipo_id)', ['campana' => $campana_id, 'estado' => 'A', 'estado_a' => 'A']); */

             $asesor = DB::selectOne('SELECT users.id,  users.name,users.email,p.telefono ,(
                select count(1) from (select id, contacto_tipo_id,fuente_contacto_id,estado_comercial_id, vendedor_id,campana_programa_id,created_at,observacion,reasignar,
                row_number() over(partition by contacto_tipo_id order by id desc) as rn
                from contacto_historicos) T where T.rn = 1
                and T.vendedor_id = users.id
                and T.estado_comercial_id in (1,3)) as total
                from campana_users
                join users on campana_users.user_id = users.id
				join profiles p on p.user_id = users.id
                where campana_id = :campana and estado = :estado
                order by total asc' ,['campana' => $campana_id, 'estado' => 'A']);



            // CREAR LEADS

            if (empty($leads)) {

                $leads = new Contacto;
                $leads->nombre = $request->nombre;
                $leads->telefono = $request->telefono;
                $leads->correo = $request->correo;
                $leads->direccion  = $direccion;
                $leads->created_by = null;
                $leads->save();

                if (!empty($leads)) {
                    $leads_tipo = TipoContacto::where('contacto_id', $leads->id)->where('tipo_id', 1)->first();

                    if (empty($leads_tipo)) {
                        $leads_tipo = new TipoContacto;
                        $leads_tipo->contacto_id = $leads->id;
                        $leads_tipo->tipo_id = 1;
                        $leads_tipo->save();
                    }

                    $historico = new ContactoHistorico;
                    $historico->contacto_tipo_id = $leads_tipo->id;
                    $historico->fuente_contacto_id = $fte_contacto;
                    $historico->campana_programa_id = $campana_programa->id;
                    $historico->estado_comercial_id = 1;
                    $historico->observacion = '';
                    $historico->nsecundario_id = $campana_programa->nsecundario_id;
                    $historico->campana_id = $campana_programa->campana_id;
                    $historico->vendedor_id = (!empty($asesor)) ? $asesor->id : null;
                    $historico->save();

                    AuditoriaContacto::auditoria($leads_tipo->id, 3, "Se asigna asesor $asesor->name");
                    $datos = TipoContacto::with('contacto')->with('contacto_historico_last')->find($leads_tipo->id);
                    event(new CrmEvents($datos)); #se guarda en la tabla notificaciones y se envia en mail al asesor
                }

                $fuente_contacto = FuentesContacto::find($fte_contacto);
                $auditoria = AuditoriaContacto::auditoria($leads_tipo->id, 1, 'Se crea Leads mediante la fuente de contacto ' . $fuente_contacto->nombre . ' del formulario ' . $campana->nombre);
                DB::commit();

                if (empty($campana_programa)) {
                    $nivel_2 = NivelSecundario::find($prog_id)->get();
                    if (empty($nivel_2)) {
                        if (!empty($asesor)) {
                            $nombre_asesor = $asesor->name;
                            $telf_asesor = $asesor->telefono;
                            $email_asesor = $asesor->email;
                            Helper::postSendMail($request->nombre, $request->correo, $nivel_2->sendinblue_id, $nombre_asesor, 'UNIVERSIDAD ECOTEC', $telf_asesor, $email_asesor);
                        }
                    }
                    return view('mailing.felicitaciones');
                }

                $sql = 'select a.id as resp_auto_id, c.cont_plantilla, a.asunto, c.opcion,b.template_id from respuesta_automatica as a
                                left join respuesta_automatica_nsecundario as b on a.id=b.resp_auto_id
                                left join mailing as c on b.mailing_id=c.id
                                left join respuesta_automatica_adjunto_nsecundario as d on d.resp_auto_adj_nsecu_id=b.id
                                left join respuesta_automatica_adjunto as e on   e.id = d.resp_auto_adj_id
                                where a.formulario_id=' . $form_id . ' and b.nsecundario_id=' . $campana_programa->nsecundario_id . ' and c.campana_id=' . $campana_id;

                $resp_auto = DB::select($sql);


                if (!empty($resp_auto[0])) {
                    //$plantilla = $resp_auto->cont_plantilla;
                    $asunto = $resp_auto[0]->asunto;
                    $plan_mod = $resp_auto[0]->cont_plantilla;
                    $imagen_carrera = $resp_auto[0]->cont_plantilla;
                    $data = [];

                    $sql = 'select a.nombre, a.resp_auto_id from respuesta_automatica_adjunto as a
                            left join respuesta_automatica_adjunto_nsecundario as b on a.id=b.resp_auto_adj_id
                            where a.resp_auto_id=' . $resp_auto[0]->resp_auto_id . ' and b.resp_auto_adj_nsecu_id=' . $campana_programa->nsecundario_id;
                    $archivo = DB::select($sql);

                    if (!empty($asesor)) {
                        $nombre_asesor = $asesor->name;
                        $telf_asesor = $asesor->telefono;
                        $email_asesor = $asesor->email;
                    }

                    Helper::postSendMail($request->nombre, $request->correo, $resp_auto[0]->template_id, $nombre_asesor, $asunto, $telf_asesor, $email_asesor);
                    return view('mailing.felicitaciones');

                } else {
                    $nivel_2 = NivelSecundario::find($prog_id);
                    if (!empty($nivel_2)) {
                        if (!empty($asesor)) {
                            $nombre_asesor = $asesor->name;
                            $telf_asesor = $asesor->telefono;
                            $email_asesor = $asesor->email;

                        }
                         Helper::postSendMail($request->nombre, $request->correo, $nivel_2->sendinblue_id, $nombre_asesor, 'UNIVERSIDAD ECOTEC', $telf_asesor, $email_asesor);
                    }
                    return view('mailing.felicitaciones');
                }


            } else {
                $leads_tipo = TipoContacto::where('contacto_id', $leads->id)->where('tipo_id', 1)->first();

                if (empty($leads_tipo)) {
                    $leads_tipo = new TipoContacto;
                    $leads_tipo->contacto_id = $leads->id;
                    $leads_tipo->tipo_id = 1;
                    $leads_tipo->save();
                }

                $nivelsec = NivelSecundario::find($prog_id);
                if (!empty($nivelsec)) {
                    $asesorAnt = TipoContacto::with('contacto_historico_last.vendedor')->find($leads_tipo->id);
                    if (!empty($asesorAnt)) {
                        $vendedorAn = CampanasUsers::where('user_id', $asesorAnt->contacto_historico_last->vendedor_id)->where('campana_id', $campana_id)->first();
                       if (!empty($vendedorAn)) {
                            $profile = Profile::where('user_id', $vendedorAn->user_id)->first();
                            $userE = User::find($vendedorAn->user_id);
                            $nombre_asesor = $userE->name;
                            $telf_asesor = $profile->telefono;
                            $email_asesor = $userE->email;
                            $asesor_id = $asesorAnt->vendedor_id;
                        }
                    }
                }



                $historico = new ContactoHistorico;
                $historico->contacto_tipo_id = $leads_tipo->id;
                $historico->fuente_contacto_id = $fte_contacto;
                $historico->campana_programa_id = $campana_programa->id;
                $historico->nsecundario_id = $campana_programa->nsecundario_id;
                $historico->campana_id = $campana_programa->campana_id;
                $historico->estado_comercial_id = 1;
                $historico->observacion = '';

                if(empty($asesor_id)){
                    $historico->vendedor_id = (!empty($asesor)) ? $asesor->id : null;
                }else{
                    $historico->vendedor_id = $asesor_id ;
                }
                $historico->save();

                $fuente_contacto = FuentesContacto::find($fte_contacto);
                $auditoria = AuditoriaContacto::auditoria($leads_tipo->id, 2, 'Se modifica Leads mediante la fuente de contacto ' . $fuente_contacto->nombre . ' del formulario ' . $campana->nombre);

                AuditoriaContacto::auditoria($leads_tipo->id, 3, "Se asigna asesor $asesor->name");
                $datos = TipoContacto::with('contacto')->with('contacto_historico_last')->find($leads_tipo->id);
                event(new CrmEvents($datos)); #se guarda en la tabla notificaciones y se envia en mail al vendedor

                DB::commit();

                if (!empty($campana_programa)) {

                    if (!empty($form_id)) {

                        $sql = 'select a.id as resp_auto_id, c.cont_plantilla, a.asunto, c.opcion,b.template_id from respuesta_automatica as a
                        left join respuesta_automatica_nsecundario as b on a.id=b.resp_auto_id
                        left join mailing as c on b.mailing_id=c.id
                        left join respuesta_automatica_adjunto_nsecundario as d on d.resp_auto_adj_nsecu_id=b.id
                        left join respuesta_automatica_adjunto as e on   e.id = d.resp_auto_adj_id
                        where a.formulario_id=' . $form_id . ' and b.nsecundario_id=' . $campana_programa->nsecundario_id . ' and c.campana_id=' . $campana_id;

                        $resp_auto = DB::select($sql);

                        if (!empty($resp_auto)) {

                            //$plantilla = $resp_auto->cont_plantilla;
                            $asunto = $resp_auto[0]->asunto;

                            $plan_mod = $resp_auto[0]->cont_plantilla;
                            $imagen_carrera = $resp_auto[0]->cont_plantilla;
                            $data = [];

                            $sql = 'select a.nombre,a.resp_auto_id from respuesta_automatica_adjunto as a
                            left join respuesta_automatica_adjunto_nsecundario as b on a.id=b.resp_auto_adj_id
                            where a.resp_auto_id=' . $resp_auto[0]->resp_auto_id . ' and b.resp_auto_adj_nsecu_id=' . $campana_programa->nsecundario_id;

                            $archivo = DB::select($sql);


                            if (empty($vendedorAn)) {
                                $nombre_asesor = $asesor->name;
                                $telf_asesor = $asesor->telefono;
                                $email_asesor = $asesor->email;
                            }

                            Helper::postSendMail($request->nombre, $request->correo, $resp_auto[0]->template_id, $nombre_asesor, $asunto, $telf_asesor, $email_asesor);

                            //Mail::to($request->correo)->send(new PlantillaFormulario($data, $asunto, $plan_mod, $request->form_id, $request->nombre, $imagen_carrera, '', $archivo, $resp_auto[0]->opcion));


                            return view('mailing.felicitaciones');

                        } else {
                            $nivel_2 = NivelSecundario::find($prog_id);
                            if (!empty($nivel_2)) {
                                if (empty($vendedorAn)) {
                                    $nombre_asesor = $asesor->name;
                                    $telf_asesor = $asesor->telefono;
                                    $email_asesor = $asesor->email;
                                }
                                Helper::postSendMail($request->nombre, $request->correo, $nivel_2->sendinblue_id, $nombre_asesor, 'UNIVERSIDAD ECOTEC', $telf_asesor, $email_asesor);
                            }
                            return view('mailing.felicitaciones');
                        }

                    } else {
                        $nivel_2 = NivelSecundario::find($prog_id);
                        if (!empty($nivel_2)) {
                            if (empty($vendedorAn)) {
                                    $nombre_asesor = $asesor->name;
                                    $telf_asesor = $asesor->telefono;
                                    $email_asesor = $asesor->email;
                                }
                                Helper::postSendMail($request->nombre, $request->correo, $nivel_2->sendinblue_id, $nombre_asesor, 'UNIVERSIDAD ECOTEC', $telf_asesor, $email_asesor);
                        }

                        return view('mailing.felicitaciones');
                    }
                } else {

                    $nivel_2 = NivelSecundario::find($prog_id);
                    if (!empty($nivel_2)) {
                        if (empty($vendedorAn)) {
                                    $nombre_asesor = $asesor->name;
                                    $telf_asesor = $asesor->telefono;
                                    $email_asesor = $asesor->email;
                                }
                                Helper::postSendMail($request->nombre, $request->correo, $nivel_2->sendinblue_id, $nombre_asesor, 'UNIVERSIDAD ECOTEC', $telf_asesor, $email_asesor);
                    }

                    return view('mailing.felicitaciones');
                }
            }


        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
            \Log::debug("---- AQUI ----");
            \Log::debug(json_encode($e->getMessage()));
        }


    }


    public function prueba(Request $request)
    {
        try {
            $asunto = 'Estamos por empezar la Jornada Académica ReThinking Management - Día 1';
            $lst = ContactoGeneral::where('estado_correo', 'P')->get();
            foreach ($lst as $item) {
                if (!empty($item->email)) {
                    $obj = ContactoGeneral::find($item->id);
                    Mail::to($item->email)->send(new PlantillaGeneral($asunto));
                    $obj->estado_correo = 'E';
                    $obj->save();
                }
            }
            return ['msg' => 'OK', 'data' => 'CORREO ENVIADO'];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }


}


