<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Respuesta;
use App\PreguntaEncuesta;
use App\Notifications\ContactoNotificacion;
use App\Events\CrmEvents;
use App\Campana;
use App\NivelSecundario;
use App\NivelPrimario;
use App\FuentesContacto;
use App\MediosGestion;
use App\TipoEstudiante;
use App\CampanasProgramas;
use App\Procedencia;
use App\Contacto;
use App\TipoContacto;
use App\ContactoHistorico;
use App\ContactoSeguimiento;
use App\EstadoComercial;
use App\Mailing;
use App\AuditoriaContacto;
use App\PermisosNPrimario;
use App\CampanasUsers;
use App\TipoEncuesta;
use App\MotivoDesintere;
use Carbon\Carbon;
use App\Mail\SendTransaccional;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use App\Helpers\Helper;

class ContactosController extends Controller
{
    protected $objinfoUser;

    public function __construct()
    {
        $this->middleware('configure');
        $this->middleware(function ($request, $next) {
            $this->objinfoUser = Session::get('infoUser');
            $this->permiso_np = Session::get('permiso_np');
            return $next($request);
        });
    }

    public function index()
    {
        //return $this->objinfoUser;
        $ofertaAcademicaAll = [];
        $ofertaUsersAll = [];
        if (!empty($this->objinfoUser->user_id)) {
            $asesor = [];
            $ofertaAcademicaAll = PermisosNPrimario::with('nprimario')->where('user_id', $this->objinfoUser->user_id)->get();

            foreach ($ofertaAcademicaAll as $nivel_p) {
                $ofertaUsersAll = PermisosNPrimario::with('user')->where('nprimario_id', $nivel_p->nprimario->id)->where('asesor_nprimario', 'SI')->get();
                foreach ($ofertaUsersAll as $value) {
                    $datos = ['id' => $value->user->id, 'name' => $value->user->name];
                    if (in_array($datos, $asesor)) {
                        break;
                    } else {
                        array_push($asesor, $datos);
                    }
                }

            }


        }
        array_push($asesor, ['id' => Auth::user()->id, 'name' => Auth::user()->name]);
        $ofertaUsersAll = $asesor;

        $campanas = [];

        if (!empty($this->objinfoUser->sede_id)) {
            $campanas = Campana::where('estado', 'A')->where('sede_id', $this->objinfoUser->sede_id)->Orwhere('sede_id', null)->get();
        } else {
            $campanas = Campana::where('estado', 'A')->get();
        }

        $nivel_primario = NivelPrimario::where('estado', 'A')->get();
        $fuente_contactos = FuentesContacto::where('estado', 'A')->get();
        $medio_gestion = MediosGestion::where('estado', 'A')->get();
        $estado_comercial = EstadoComercial::where('tipo', 'L')->get();
        $estado_comercial_seguimientos = EstadoComercial::where('tipo', 'S')->get();
        $tipo_estudiante = TipoEstudiante::all();
        $procedencias = Procedencia::all();
        $Mailings = Mailing::all();
        $otrosProgramas = NivelSecundario::all();
        $TipoEncuesta = TipoEncuesta::where('estado', 'A')->get();
        $MotivoDesinteres = MotivoDesintere::where('estado', 'A')->get();
        // $vendedores =
        return view('leads.index', compact('campanas', 'nivel_primario', 'fuente_contactos', 'medio_gestion', 'tipo_estudiante', 'procedencias', 'Mailings', 'estado_comercial', 'estado_comercial_seguimientos', 'otrosProgramas', 'ofertaAcademicaAll', 'ofertaUsersAll','TipoEncuesta','MotivoDesinteres'));
    }

    public function indexclientes()
    {
        $campanas = [];
        if (!empty($this->objinfoUser)) {
            $campanas = Campana::where('estado', 'A')->where('sede_id', $this->objinfoUser->sede_id)->get();
        } else {
            $campanas = Campana::where('estado', 'A')->get();
        }
        $nivel_primario = NivelPrimario::where('estado', 'A')->get();
        $fuente_contactos = FuentesContacto::where('estado', 'A')->get();
        $medio_gestion = MediosGestion::where('estado', 'A')->get();
        $estado_comercial = EstadoComercial::where('tipo', 'L')->get();
        $estado_comercial_seguimientos = EstadoComercial::where('tipo', 'S')->get();
        $tipo_estudiante = TipoEstudiante::all();
        $procedencias = Procedencia::all();
        $Mailings = Mailing::all();

        return view('clientes.index', compact('campanas', 'nivel_primario', 'fuente_contactos', 'medio_gestion', 'tipo_estudiante', 'procedencias', 'Mailings', 'estado_comercial', 'estado_comercial_seguimientos'));
    }

    public function leadsinfo(Request $request)
    {
        $that = $this;

        $permiso_np = isset($this->permiso_np) ? implode(',',$this->permiso_np) : 0;

        if($request->fecha_seguimiento != 'S'){
            // $fecha_ini = date('Y-m',strtotime($request->fecha_ini)) .'-01 00:00:00';
            // $fecha_fin = date('Y-m',strtotime($request->fecha_ini)) .'-'.date('t',strtotime($request->fecha_ini)).' 23:59:59';
            $fecha_ini = $request->fecha_ini;
            $fecha_fin = $request->fecha_fin;

        }else{
            $fecha_ini = $request->fecha_ini;
            $fecha_fin = $request->fecha_fin;
        }


        if($request->fecha_seguimiento == 'S'){
            $fecha_active = 1;
        }else{
            $fecha_active = 0;
        }
        $datos = $fecha_active;
        $datos = DB::select('EXEC sp_gestion_leads_consulta ?,?,?,?,?,?,?,?,?,?',
        [
            $fecha_ini,
            $fecha_fin,
            $fecha_active,
            $request->estado,
            $request->fuente_search,
            $request->asesor_search,
            $request->oferta_search,
            $request->campain_search,
            $request->programa_search,
            Auth::user()->id,
        ]);
        return datatables($datos)
        ->toJson();

    }
    public function dataleads(Request $request)
    {
        $that = $this;

        $permiso_np = isset($this->permiso_np) ? implode(',',$this->permiso_np) : 0;

        return datatables()
            ->eloquent(
                ContactoHistorico::with('contacto_tipo')
                ->whereHas('contacto_tipo', function ($query) {
                    $query->where('tipo_id', 1); #leads
                })
                ->with('contacto_tipo.contacto')
                #->with('contacto_tipo.contacto.creado_por')
                ->whereHas('contacto_tipo.contacto', function ($query) {
                    $query->where('estado', 'A');
                })
                ->with('fuente_contacto')
                ->with('campana_programa')
                ->whereHas('campana_programa', function ($query) use ($request,$permiso_np) {
                    if ($request->oferta_search != null) {
                        $query->whereIn('nsecundario_id', function ($query) use ($request) {
                            $query->select('id')
                                ->from('nivel_secundario')
                                ->whereRaw("nivel_secundario.nprimario_id = $request->oferta_search");
                        });
                    } else {
                        $query->whereIn('nsecundario_id', function ($query) use ($request,$permiso_np) {
                            $query->select('id')
                                ->from('nivel_secundario')
                                ->whereRaw("nivel_secundario.nprimario_id in ($permiso_np)");
                        });
                    }
                })
                ->with('campana_programa.programa')
                ->whereHas('campana_programa.programa', function ($query) use ($request) {
                    if ($request->programa_search != null) {
                        $query->where('id', $request->programa_search);
                    } else {
                        $query;
                    }
                })
                ->with('campana_programa.campana')
                ->whereHas('campana_programa.campana', function ($query) use ($that) {
                    if ($that->objinfoUser->sede_id != null) {
                        $query->where('sede_id', $that->objinfoUser->sede_id)->orWhereNull('sede_id');
                    } else {
                        $query;
                    }
                })
                ->whereHas('campana_programa.campana', function ($query) use ($request) {
                    if ($request->campain_search != null) {
                        $query->where('id', $request->campain_search);
                    } else {
                        $query;
                    }
                })
                ->with('otro_pragrama')
                ->with('estado_comercial')
                ->with('vendedor')
                ->with('creado_por')
                ->whereIn('id', function ($sub) {
                    $sub->selectRaw('max(id)')->from('contacto_historicos')->groupBy('contacto_tipo_id'); // <---- la clave
                })
                ->whereBetween('created_at',[$request->fecha_ini, $request->fecha_fin])
                ->when($request->estado, function ($query) use ($request) {
                    $query->where('estado_comercial_id', $request->estado);
                })
                ->when($request->fuente, function ($query) use ($request) {
                    $query->where('fuente_contacto_id', $request->fuente);
                })
                ->when($request->asesor_search, function ($query) use ($request) {
                     $query->where('vendedor_id', $request->asesor_search);
                })
            )
            ->addColumn('opciones', 'leads.opciones') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('detail', function ($arrProduct) {
                $info = "";
                $info .= "<b>Campaña: </b>".$arrProduct['campana_programa']['campana']['nombre'] . "<br>";
                $info .= "<b>Programa: </b>".$arrProduct['campana_programa']['programa']['nombre'] . "<br>";
                return $info;
            }) #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('opt', function ($arrProduct) {
                $id = $arrProduct['contacto_tipo_id'];
                return "<img onclick='abrir(this,$id)' src='/images/details_open.png' style='cursor: pointer;'/>";
            })
            ->addColumn('ingreso', function ($arrProduct) {
                $ingreso = "";
               # $ingreso .= $arrProduct['contacto_tipo']['contacto']['creado_por']['name'] . " <br>";
                $ingreso .= \Carbon\Carbon::parse($arrProduct['created_at'])->format('Y-m-d h:i:s A') . "<br>";
                return $ingreso;
            })
            ->addColumn('datos', function ($arrProduct) {
                $count = TipoContacto::where('contacto_id', $arrProduct['contacto_tipo']['contacto_id'])->where('tipo_id', 2)->count();
                $info = "";
                $info .= "<a href='#' data-toggle='modal' data-target='.modal-contacto' onclick='editar(".$arrProduct['contacto_tipo_id'].")'> ".$arrProduct['contacto_tipo']['contacto']['nombre'] . "</a><br>";
                $info .= $arrProduct['contacto_tipo']['contacto']['correo'] . "<br>";
                $info .= $arrProduct['contacto_tipo']['contacto']['telefono'] . "<br>";
                $isCliente = $count > 0 ? '<div class="mb-2 mr-2 badge badge-success">Este Leads es un cliente</div>' : '';
                $info .= $isCliente;
                return $info;
            })
            ->rawColumns(['opciones', 'opt', 'datos', 'detail', 'ingreso']) #opcion para que presente el HTML
            ->toJson();
    }

    public function dataclientes(Request $request)
    {
        $that = $this;
        return datatables()
            ->eloquent(TipoContacto::with('contacto')->with('contacto.creado_por')->with('contacto_historico_last')
                ->with('contacto_historico_last.fuente_contacto')
                ->whereHas('contacto_historico_last.fuente_contacto', function ($query) use ($request) {
                    if ($request->fuente) {
                        $query->where('fuente_contacto_id', $request->fuente);
                    } else {
                        $query;
                    }
                })
                ->with('contacto_historico_last.campana_programa')->with('contacto_historico_last.campana_programa.programa')
                ->with('contacto_historico_last.campana_programa.campana')
                ->whereHas('contacto_historico_last.campana_programa.campana', function ($query) use ($that) {
                    if ($that->objinfoUser->sede_id != null) {
                        $query->where('sede_id', $that->objinfoUser->sede_id)->orWhereNull('sede_id');
                    } else {
                        $query;
                    }
                })
                ->with('contacto_historico_last.estado_comercial')->with('contacto_historico_last.vendedor')->where('tipo_id', 2))
            ->addColumn('opciones', 'clientes.opciones') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('detail', 'clientes.detail') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('ingreso', function ($arrProduct) {
                $ingreso = "";
                $ingreso .= $arrProduct['contacto']['creado_por']['name'] . "<br>";
                $ingreso .= \Carbon\Carbon::parse($arrProduct['contacto_historico_last']['created_at'])->format('Y-m-d H:m:s');
                return $ingreso;
            })
            ->addColumn('opt', function ($arrProduct) {
                $id = $arrProduct['id'];
                return "<img onclick='abrir(this,$id)' src='/images/details_open.png' style='cursor: pointer;'/>";
            })
            ->addColumn('datos', function ($arrProduct) {
                $count = TipoContacto::where('contacto_id', $arrProduct['contacto_id'])->where('tipo_id', 2)->count();
                $info = "";
                $info .= $arrProduct['contacto']['nombre'] . "<br>";
                $info .= $arrProduct['contacto']['correo'] . "<br>";
                $info .= $arrProduct['contacto']['telefono'] . "<br>";
                return $info;
            })
            ->rawColumns(['opciones', 'opt', 'datos', 'detail', 'ingreso']) #opcion para que presente el HTML
            ->toJson();
    }

    public function historialLeads(Request $request)
    {
        return ContactoHistorico::with('fuente_contacto')->with('campana_programa')->with('campana_programa.programa')->with('campana_programa.campana')->with('otro_pragrama')->with('estado_comercial')->with('vendedor')->with('creado_por')->where('contacto_historicos.contacto_tipo_id', $request->id)->orderBy('contacto_historicos.created_at', 'desc')->get();
    }

    public function campanaPrograma(Request $request)
    {
        $datos = [];

        $datos['programas'] = CampanasProgramas::with('programa')->where('campana_id', $request->id)->get();

        $datos['vendedores'] = CampanasUsers::with('user')->where('campana_id', $request->id)->get();

        return $datos;
    }


    public function newContactoHistorico(Request $request){

    }
    public function postLeads(Request $request)
    {
        try {
            DB::beginTransaction();

            $leads = Contacto::orWhere('id',$request->contacto_id)->orWhere('correo', 'LIKE', '%' . $request->email . '%')->orWhere('telefono',$request->telefono)->first();
            if (empty($leads)) { //creo
                $leads = new Contacto;
                $leads->nombre = $request->nombre;
                $leads->cedula = $request->cedula;
                $leads->correo = $request->email;
                $leads->telefono = $request->telefono;
                $leads->genero = $request->genero;
                $leads->direccion = $request->direccion;
                //$leads->procedencia_id = $request->procedencia;
                $leads->procedencia = $request->procedencia;
                $leads->tipo_estudiante_id = $request->tipo_estudiante;
                $leads->created_by = Auth::user()->id;
                $leads->save();

                if (!empty($leads)) {
                    $leads_tipo = TipoContacto::where('contacto_id', $leads->id)->where('tipo_id', $request->tipo_id)->first();
                    $programa = CampanasProgramas::find($request->programa);

                    if (empty($leads_tipo)) {
                        $leads_tipo = new TipoContacto;
                        $leads_tipo->contacto_id = $leads->id;
                        $leads_tipo->tipo_id = $request->tipo_id;
                        $leads_tipo->save();
                    }
                    //nuevo contacto historico
                    $historico = new ContactoHistorico;
                    $historico->contacto_tipo_id = $leads_tipo->id;
                    $historico->fuente_contacto_id = $request->fuente;
                    $historico->campana_programa_id = $request->programa;
                    $historico->otro_porgrama_id = $request->otros;
                    $historico->estado_comercial_id = $request->tipo_id == 1 ? 1 : 11;
                    $historico->vendedor_id = $request->vendedor;
                    $historico->observacion = $request->observacion;
                    $historico->nsecundario_id = $programa->nsecundario_id;
                    $historico->campana_id = $programa->campana_id;
                    $historico->created_by = Auth::user()->id;
                    $historico->save();
                }

                $tipo_value = $request->tipo_id == 1 ? 'lead' : 'cliente';
                AuditoriaContacto::auditoria($leads_tipo->id, 1, "Se creo $tipo_value por formulario de nuevo $tipo_value");
                AuditoriaContacto::auditoria($leads_tipo->id, 3, "Se asigna estado comercial Por Gestionar");
                if (!empty($request->vendedor)) {
                    $vendedor = User::find($request->vendedor);
                    AuditoriaContacto::auditoria($leads_tipo->id, 3, "Se asigna asesor $vendedor->name");
                    $datos = TipoContacto::with('contacto')->with('contacto_historico_last')->find($leads_tipo->id);
                    event(new CrmEvents($datos)); #se guarda en la tabla notificaciones y se envia en mail al vendedor
                }
                DB::commit();
                $result = $leads ? ['msg' => 'success', 'data' => 'Se ha creado correctamente el leads '] : ['msg' => 'error', 'data' => 'Ocurrio un error al crear el leads '];

                return response()->json($result);

            } else {//edito
                if (empty($leads)) {
                    $leads = $veri_correo;
                }
                $leads->nombre = $request->nombre;
                $leads->cedula = $request->cedula;
                $leads->telefono = $request->telefono;
                $leads->correo = $request->email;
                $leads->genero = $request->genero;
                $leads->direccion = $request->direccion;
                //$leads->procedencia_id = $request->procedencia;
                $leads->procedencia = $request->procedencia;
                $leads->tipo_estudiante_id = $request->tipo_estudiante;
                $leads->created_by = Auth::user()->id;
                $leads->save();

                if (!empty($leads)) {
                    $leads_tipo = TipoContacto::where('contacto_id', $leads->id)->where('tipo_id', 1)->first();

                    if (empty($leads_tipo)) {
                        $leads_tipo = new TipoContacto;
                        $leads_tipo->contacto_id = $leads->id;
                        $leads_tipo->tipo_id = 1;
                        $leads_tipo->save();
                    }
                    $leads_tipo = TipoContacto::with('contacto_historico_last')->where('contacto_id', $leads->id)->first();
                    $programa = CampanasProgramas::find($request->programa);
                    if ($request->editar=="SI") {
                        $historico = ContactoHistorico::find($leads_tipo->contacto_historico_last->id);
                        $historico->contacto_tipo_id = $leads_tipo->id;
                        $historico->fuente_contacto_id = $request->fuente;
                        $historico->campana_programa_id = $request->programa;
                        $historico->otro_porgrama_id = $request->otros;
                        //$historico->estado_comercial_id = 1;
                        $historico->vendedor_id = $request->vendedor;
                        $historico->observacion = $request->observacion;
                        $historico->nsecundario_id = $programa->nsecundario_id;
                        $historico->campana_id = $programa->campana_id;
                        $historico->created_by = Auth::user()->id;
                        $historico->save();
                    }else{
                        //nuevo contacto historico
                        $historico = new ContactoHistorico;
                        $historico->contacto_tipo_id = $leads_tipo->id;
                        $historico->fuente_contacto_id = $request->fuente;
                        $historico->campana_programa_id = $request->programa;
                        $historico->otro_porgrama_id = $request->otros;
                        $historico->estado_comercial_id = $request->tipo_id == 1 ? 1 : 11;
                        $historico->vendedor_id = $request->vendedor;
                        $historico->observacion = $request->observacion;
                        $historico->nsecundario_id = $programa->nsecundario_id;
                        $historico->campana_id = $programa->campana_id;
                        $historico->created_by = Auth::user()->id;
                        $historico->save();
                    }
                }

                $tipo_value = $request->tipo_id == 1 ? 'lead' : 'cliente';
                AuditoriaContacto::auditoria($leads_tipo->id, 2, "Se modifico $tipo_value por formulario $tipo_value");
                DB::commit();

                $result = $leads ? ['msg' => 'success', 'data' => 'Se ha modificado correctamente el leads '] : ['msg' => 'error', 'data' => 'Ocurrio un error al modificar el leads '];

                return response()->json($result);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
        }
    }

    public function show(Request $request)
    {
        return TipoContacto::with('contacto')->with('contacto_historico_last')->with('contacto_historico_last.fuente_contacto')->with('contacto_historico_last.campana_programa')->with('contacto_historico_last.campana_programa.programa')->with('contacto_historico_last.campana_programa.campana')->with('contacto_historico_last.estado_comercial')->with('contacto_historico_last.vendedor')->where('id', $request->id)->first(); //revisar por que le pongo el tipo_id 1
    }

    public function seguimientoShow(Request $request)
    {
        $datos = TipoContacto::with('contacto')->with('contacto_historico_last')->with('contacto_historico_last.fuente_contacto')->with('contacto_historico_last.campana_programa')->with('contacto_historico_last.campana_programa.programa')->with('contacto_historico_last.campana_programa.campana')->with('contacto_historico_last.estado_comercial')->with('contacto_historico_last.vendedor')->with('contacto_historico_last.creado_por')->with('contacto_seguimiento')->with('contacto_seguimiento.estado_comercial')->with('contacto_seguimiento.medio_gestion')->with('contacto_seguimiento.creado_por')->where('id', $request->id)->first();
        //return $datos;
        return view('leads.seguimiento', compact('datos'));
    }

    public function showAuditoria(Request $request)
    {
        $datos = TipoContacto::with('contacto_historico_last')->with('contacto_historico_last.fuente_contacto')->with('contacto_historico_last.campana_programa')->with('contacto_historico_last.campana_programa.programa')->with('contacto_historico_last.campana_programa.campana')->with('contacto_historico_last.estado_comercial')->with('contacto_historico_last.vendedor')->with('contacto_historico_last.creado_por')->with('autoria_contacto')->with('autoria_contacto.creado_por')->with('autoria_contacto.accion')->where('id', $request->id)->first();
        //return $datos;
        return view('leads.seguimiento', compact('datos'));
    }

    public function seguimiento(Request $request)
    {
        $seguimiento_update = ContactoSeguimiento::where('contacto_tipo_id',$request->seguimiento_tipo_contacto_id)->update(['ultimo_seguimiento'=>'N']);

        $seguimiento = new ContactoSeguimiento;
        $seguimiento->contacto_tipo_id = $request->seguimiento_tipo_contacto_id;
        $seguimiento->estado_comercial_id = $request->seguimiento_modal;
        $seguimiento->medio_gestion_id = $request->medio_gestion_seguimiento;
        $seguimiento->observacion = $request->observacion_seguimiento;
        $seguimiento->ultimo_seguimiento = 'S';
        $seguimiento->fecha_prox_contacto = $request->fch_prox_contacto ?? date('Y').'-'.date('m').'-'.date('d').' '.date('H:i:s.v');
        $seguimiento->created_by = Auth::user()->id;
        $seguimiento->save();

        $estadoComercial = EstadoComercial::find($request->seguimiento_modal);
        $obs = $estadoComercial->nombre . ', ' . $request->observacion_seguimiento;
        AuditoriaContacto::auditoria($request->seguimiento_tipo_contacto_id, 6, "$obs");

        $result = $seguimiento ? ['msg' => 'success', 'data' => 'Seguimiento registrado con éxito'] : ['msg' => 'error', 'data' => 'Ocurrio un error al registrar el Seguimiento '];

        return response()->json($result);
    }

    public function sendTransaccional(Request $request)
    {

        $emails = [$request->para, $request->cc];
        $data = [];
        $data = TipoContacto::with('contacto')->with('contacto_historico_last')->with('contacto_historico_last.vendedor')->with('contacto_historico_last.vendedor.profile')->find($request->id);

        $vendedor = $data->contacto_historico_last->vendedor->name ?? 'Sin Asignar';;
        $emailVendedor = $data->contacto_historico_last->vendedor->email ?? 'Sin Asignar';
        $telfVendedor = $data->contacto_historico_last->vendedor->profile->celular ?? 'Sin Asignar';

        $idtemplate = $request->grado_template == 'S' ? 397 : $request->templateid;

        Helper::postSendMail($request->nombre, $request->para, $idtemplate, $vendedor, $request->asunto, $telfVendedor, $emailVendedor);

        $seguimiento = AuditoriaContacto::auditoria($request->id, 5, "Se envia correo mediante el modulo de envio transaccional");

        $result = $seguimiento ? ['msg' => 'success', 'data' => 'se ha enviado un correo electronico'] : ['msg' => 'error', 'data' => 'Ocurrio un error al enviar el correo'];

        return response()->json($result);
    }

    public function estadoComercial(Request $request)
    {
        //$ultimo_historico = TipoContacto::with('contacto_historico_last')->find($request->estado_tipo_contacto_id);
        $ultimo_historico = ContactoHistorico::find($request->estado_contacto_historico_id);
        if (!empty($ultimo_historico)) {
            $historico = ContactoHistorico::find($ultimo_historico->id);
            $historico->estado_comercial_id = $request->estado_comercial_modal;
            $historico->observacion = $request->observacion_estado;

            if(!empty($request->seguimiento_modal)){
                $fecha = $request->fch_prox_contacto ?? date('Y').'-'.date('m').'-'.date('d');
                $hora = $request->hora ?? date('H:i:s');
                $historico->fecha_prox_contacto = $fecha .' '.$hora;
            }

            $historico->motivo_desinteres_id = $request->desinteres_modal;
            $historico->save();

            $estadoComercial = EstadoComercial::find($request->estado_comercial_modal);
            AuditoriaContacto::auditoria($request->estado_tipo_contacto_id, 3, "Se actualizo el estado comercial por $estadoComercial->nombre, Observación: $request->observacion_estado");

            if(!empty($request->seguimiento_modal)){
                #actualizo y seteo que ya no va a ser su ultimo sgeuimiento
                $seguimiento_update = ContactoSeguimiento::where('contacto_tipo_id',$request->estado_tipo_contacto_id)->update(['ultimo_seguimiento'=>'N']);

                $seguimiento = new ContactoSeguimiento;
                $seguimiento->contacto_tipo_id = $request->estado_tipo_contacto_id;
                $seguimiento->estado_comercial_id = $request->seguimiento_modal;
                $seguimiento->medio_gestion_id = $request->medio_gestion_seguimiento;
                $seguimiento->observacion = $request->observacion_estado;
                $fecha = $request->fch_prox_contacto ?? date('Y').'-'.date('m').'-'.date('d');
                $hora = $request->hora ?? date('H:i:s');
                $seguimiento->fecha_prox_contacto = $fecha .' '.$hora;
                $seguimiento->created_by = Auth::user()->id;
                $seguimiento->ultimo_seguimiento = 'S';
                $seguimiento->save();

                $obs = $estadoComercial->nombre . ', ' . $request->observacion_estado;
                AuditoriaContacto::auditoria($request->estado_tipo_contacto_id, 6, "$obs");

            }

            if(!empty($request->desinteres_modal)){
                $obs = $estadoComercial->nombre . ', Motivo: ' . $request->desinteres_nombre . ', Observación: ' . $request->observacion_estado;
                AuditoriaContacto::auditoria($request->estado_tipo_contacto_id, 6, "$obs");
            }

            $result = $historico ? ['msg' => 'success', 'data' => 'se ha cambiado el estado comercial'] : ['msg' => 'error', 'data' => 'Ocurrio un error al cambiar el estado comercial'];

            return response()->json($result);
        } else {
            return response()->json(['msg' => 'error', 'data' => 'Debe asignarle un programa al leads']);
        }

    }

    public function registro_auditoria(Request $request)
    {

        AuditoriaContacto::auditoria($request->id, 11, "Ha sido contactado");
        return response()->json(['msg' => 'success', 'data' => 'Se guardo en la auditoria']);
    }

    public function otrosProgramas(Request $request)
    {
        return NivelSecundario::all();
    }


    public function viewDataLead(Request $request)
    {
        return Contacto::where('cedula', $request->cedula)->first();
    }

    public function SingleSingOnElastix()
    {
        try {

            $baseUrl = env('API_ENDPOINT');

            $headers = [
                'Accept' => 'application/json',
                "Content-Type", "application/x-www-form-urlencoded"
            ];

            $client = new Client([
                'base_uri' => $baseUrl,
                'headers' => $headers,
                'verify' => false
            ]);

            $form_params = [
                'trama_login_ws' => '{"agentnumber" : "' . $this->objinfoUser->extension . '","agentpassword" : "' . $this->objinfoUser->extension . '","agentname" :"SIP/' . $this->objinfoUser->extension . '","extension" :"' . $this->objinfoUser->extension . '"}'
            ];

            $response = $client->request('POST', '/modules/redlinks_ws/RestControllerWS.php/agentlogin', [
                'form_params' => $form_params
            ]);

            $response = json_decode($response->getBody(), true);

            return response()->json(['msg' => 'success', 'data' => 'Conexión exitosa con la central telefónica de Elastix. ']);

            //print_r($response);

        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            return response()->json(['msg' => 'error', 'data' => 'No se puede conectar al servidor de elastix. ' . $e->getMessage()]);
        }
    }

    public function llamada(Request $request)
    {


        try {
            if (empty($this->objinfoUser->extension)) {
                return response()->json(['msg' => 'error', 'data' => 'No posee una extension registrada']);
            }

            if (empty($request->telefono)) {
                return response()->json(['msg' => 'error', 'data' => 'El contacto no tiene registrado un numero de Teléfono']);
            }

            $telefono = '0'.Helper::phone($request->telefono);

            $this->SingleSingOnElastix();

            $baseUrl = env('API_ENDPOINT');

            $headers = [
                'Accept' => 'application/json',
                "Content-Type", "application/x-www-form-urlencoded"
            ];

            $client = new Client([
                'base_uri' => $baseUrl,
                'headers' => $headers,
                'verify' => false
            ]);

            $form_params = [
                'trama_param_manualcall_ws' => '{"id_manual_campaign": "8","agenttype": "SIP","agentnumber":"' . $this->objinfoUser->extension . '","phone":"' . $telefono . '"}'
            ];

            $response = $client->request('POST', '/modules/redlinks_ws/RestControllerWS.php/param_manualcall_ws', [
                'form_params' => $form_params
            ]);

            AuditoriaContacto::auditoria($request->tipo_contacto_id, 8, "Se registro una llamada al número $telefono");
            return json_decode($response->getBody(), true);


        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            return response()->json(['msg' => 'error', 'data' => 'No se puede conectar al servidor de elastix. ' . $e->getMessage()]);
        }
    }


    public function campanaByoffers(Request $request)
    {
        $datos['campanias'] = DB::select("SELECT distinct c.nombre,c.id from  campana_programa cp  join
        campana c on cp.campana_id = c.id join nivel_secundario ns on cp.nsecundario_id = ns.id join
        nivel_primario np on ns.nprimario_id = np.id where np.id = ? and c.estado = 'A'", [$request->id]);
        $datos['programas'] = NivelSecundario::where('nprimario_id',$request->id)->get();
        return $datos;
    }

    public function llamadaEntrante(Request $request)
    {
        $resultado = DB::select(" exec sp_find_client_telf ? ", [$request->telefono]);
        $datos = [];
        if (!empty($resultado)) {

            $contacto_tipo_id = $resultado[0]->cliente_id > 0 ? $resultado[0]->cliente_id : $resultado[0]->lead_id;
            AuditoriaContacto::auditoria($contacto_tipo_id, 8, "Se registro una llamada $request->tipo del número $request->telefono");

            $datos['nombre'] = $resultado[0]->nombre;
            $datos['telefono'] = $request->telefono;
            $datos['tipo'] = $resultado[0]->cliente_id > 0 ? 'cliente' : 'leads';
            $datos['id'] = $contacto_tipo_id;
        } else {
            $datos['nombre'] = "Desconocido";
            $datos['telefono'] = $request->telefono;
            $datos['tipo'] = 'leads';
            $datos['id'] = 0;
        }
        return $datos;
    }

    public function preguntas(Request $request)
    {
        $data['preguntas'] = PreguntaEncuesta::with('tipo_encuesta')->where('estado', 'A')->where('nivel_primario_id', $request->nivel_primario_id)->where('tipo_encuesta_id', $request->tipo_encuesta_id)->get();
        $data['respuestas'] = Respuesta::where('tipo_contacto_id', $request->id)->where('estado', 'A')->get();
        return $data;
    }


    public function preguntasPost(Request $request)
    {
        $verificarPregunta = PreguntaEncuesta::where('estado', 'A')->where('nivel_primario_id', $request->pregunta_nivel_primario_id)->where('tipo_encuesta_id', $request->tipo_encuesta)->get();
        $verificarRespuesta = Respuesta::where('tipo_contacto_id', $request->pregunta_tipo_contacto_id)->where('estado', 'A')
                ->whereIn('pregunta_id', function ($query) use ($request) {
                            $query->select('id')
                                ->from('pregunta_encuesta')
                                ->whereRaw("pregunta_encuesta.nivel_primario_id = $request->pregunta_nivel_primario_id")
                                ->whereRaw("pregunta_encuesta.estado = 'A'")
                                ->whereRaw("pregunta_encuesta.tipo_encuesta_id = $request->tipo_encuesta");
                })->count();

        if ($verificarRespuesta > 0) {
            return response()->json(['msg' => 'error', 'data' => 'No se puede cambiar las respuestas de las preguntas']);
        }

        if (!empty($verificarPregunta)) { #verificar si existen preguntas


            foreach ($verificarPregunta as $key => $pregunta) {
                $campo = 'campo_' . $pregunta->id;
                if (empty($request[$campo])) {
                    return response()->json(['msg' => 'error', 'data' => 'La pregunta ' . $pregunta->texto . ' es obligatoria']);
                }
            }

            foreach ($verificarPregunta as $key => $pregunta) {
                $campo = 'campo_' . $pregunta->id;
                $respuesta = new Respuesta;
                $respuesta->tipo_contacto_id = $request->pregunta_tipo_contacto_id;
                $respuesta->pregunta_id = $pregunta->id;
                $respuesta->respuesta = $request[$campo];
                $respuesta->save();
            }
        }

        return ['msg' => 'success', 'data' => 'Respuestas guardardas con éxito'];
    }

    public function delete(Request $request){
        $tipoContacto = TipoContacto::find($request->id);

        $contacto = Contacto::find($tipoContacto->contacto_id);
        $contacto->estado = 'E';
        $contacto->save();

        return ['msg' => 'success', 'data' => 'Lead eliminado con éxito'];
    }

    public function editContacto(Request $request){

        try {
            $veri_correo = Contacto::where('correo',$request->correo_edit)->where('id','<>',$request->contacto_id_edit)->first();
            if (!empty($veri_correo)) {
                return response()->json(['msg' => 'error', 'data' => 'El correo '.$veri_correo->correo.' pertenece al contacto '.$veri_correo->nombre ]);
            }
            $contacto = Contacto::find($request->contacto_id_edit);
            $contacto->nombre = $request->nombre_edit;
            $contacto->cedula = $request->cedula_edit;
            $contacto->correo = $request->correo_edit;
            $contacto->telefono = $request->telefono_edit;
            $contacto->genero = $request->genero_edit;
            $contacto->direccion = $request->direccion_edit;
            //$contacto->procedencia_id = $request->procedencia_edit;
            $contacto->procedencia = $request->procedencia_edit;
            $contacto->tipo_estudiante_id = $request->tipo_estudiante_edit;
            $contacto->estado = 'A';
            $contacto->save();

            $leads_tipo = TipoContacto::where('contacto_id',$request->contacto_id_edit)->where('tipo_id',1)->first();
            AuditoriaContacto::auditoria($leads_tipo->id, 2, "Se actualizo información de contacto del leads");

            $result = $contacto ? ['msg' => 'success', 'data' => 'Información actualizada '] : ['msg' => 'error', 'data' => 'Ocurrio un error al actualizar la información'];

            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
        }

    }

}
