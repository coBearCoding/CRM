<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Estados;
use App\EmailTrans;
use App\Campana;
use App\NivelSecundario;
use App\NivelPrimario;
use App\FuentesContacto;
use App\MediosGestion;
use App\TipoEstudiante;
use App\CampanasProgramas;
use App\Procedencia;

class LeadsController extends Controller
{
    protected $objinfoUser;

    public function __construct() {
		$this->middleware('configure');
        $this->middleware(function ($request, $next){
            $this->objinfoUser = Session::get('infoUser');
            return $next($request);
        });
	}

    public function index()
    {
        //$emails_trans = EmailTrans::where('st_email','A')->get();
        $campanas = Campana::where('estado','A')->get();
        $nivel_primario = NivelPrimario::where('estado','A')->get();
        $fuente_contactos = FuentesContacto::where('estado','A')->get();
        $medio_gestion = MediosGestion::where('estado', 'A')->get();
        $tipo_estudiante = TipoEstudiante::all();
        $procedencias = Procedencia::all();
    	return view('leads.index',compact('campanas','nivel_primario','fuente_contactos','medio_gestion','tipo_estudiante'));
    }

    public function data_back(Request $request)
    {
        $estados =  Estados::where('tipo','l')->get();

        return datatables()
            ->eloquent(Leads::with('programa')->with('oferta_academica')->with('vendedor')->with('fuente_contacto')->where('leads.st_lead','A'))
            ->addColumn('datos','leads.datos') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('opciones','leads.opciones') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('estado', function($arrProduct)use(&$estados){
                $select = '<select class="form-control">';
                foreach ($estados as $key => $value) {
                    $select .= '<option id="'.$value->sigla.'">'.$value->nombre.'</option>';
                }
                $select .= '</select>';
                return $select;
            })
            ->addColumn('opt', function($arrProduct){
                $id = $arrProduct['cod_lead'];
	          	return "<img onclick='abrir(this,$id)' src='/images/details_open.png' style='cursor: pointer;'/>";
	        })
        	->rawColumns(['datos','estado','opciones','opt']) #opcion para que presente el HTML
            ->toJson();
    }

    public function data(Request $request)
    {
        /*return Leads::with('estado_comercial')->with('leads_historico')->with('leads_historico.fuente_contacto')->with('leads_historico.campana_programa')->with('leads_historico.campana_programa.programa')->with('leads_historico.campana_programa.campana')->where('leads.estado','A')->get();*/
        return datatables()
            ->eloquent(Leads::with('estado_comercial')->where('leads.estado','A'))
            ->addColumn('opciones','leads.opciones') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('opt', function($arrProduct){
                $id = $arrProduct['id'];
                return "<img onclick='abrir(this,$id)' src='/images/details_open.png' style='cursor: pointer;'/>";
            })
            ->rawColumns(['opciones','opt']) #opcion para que presente el HTML
            ->toJson();
    }

    public function ofertaByPrograma(Request $request){
        $result=  NivelSecundario::where('estado','A')->where('id',$request->cod_programa)->get();
        return $result;
    }

    public function campanaPrograma(Request $request){
         return CampanasProgramas::with('programa')->where('campana_id',$request->id)->get();
    }

    public function post(Request $request){
        $leads =  Leads::find($request->id);

        if (empty($leads)) {//creo
            $leads = new Leads;
            $leads->nom_lead = $request->nombre;
            $leads->ced_lead = $request->cedula;
            $leads->genero = $request->genero;
            $leads->campaingid = $request->campana;
            $leads->cod_oferta_academica = $request->oferta_academica;
            $leads->cod_programa = $request->programa;
            $leads->email_lead = $request->email;
            $leads->programa_adicional = $request->otros;
            $leads->telf_lead = $request->telefono;
            $leads->direccion_lead = $request->direccion;
            $leads->cod_fuente_contacto = $request->fuente;
            $leads->cod_medio_gestion = $request->medio;
            $leads->fecha_creacion = date('Y-m-d');
            $leads->hora_creacion = date('H:i:s');
            $leads->st_lead = 'A';
            $leads->cod_usuario = '1'; #aqui vendedor
            $leads->comentario = $request->observacion;
            $leads->save();

            $result = $leads ? ['msg' => 'success', 'data' => 'Se ha creado correctamente el leads ' ] : ['msg' => 'error', 'data' => 'Ocurrio un error al crear el leads '];

            return response()->json($result);

        }else{//edito
            $leads->nom_lead = $request->nombre;
            $leads->ced_lead = $request->cedula;
            $leads->genero = $request->genero;
            $leads->campaingid = $request->campana;
            $leads->cod_oferta_academica = $request->oferta_academica;
            $leads->cod_programa = $request->programa;
            $leads->email_lead = $request->email;
            $leads->programa_adicional = $request->otros;
            $leads->telf_lead = $request->telefono;
            $leads->direccion_lead = $request->direccion;
            $leads->cod_fuente_contacto = $request->fuente;
            $leads->cod_medio_gestion = $request->medio;
            $leads->fecha_creacion = date('Y-m-d');
            $leads->hora_creacion = date('H:i:s');
            $leads->st_lead = 'A';
            $leads->cod_usuario = '1'; #aqui vendedor
            $leads->comentario = $request->observacion;
            $leads->save();
            
            $result = $leads ? ['msg' => 'success', 'data' => 'Se ha modificado correctamente el leads ' ] : ['msg' => 'error', 'data' => 'Ocurrio un error al modificar el leads '];

            return response()->json($result);
        }

    }

    public function show(Request $request)
    {
        return Leads::with('programa')->with('oferta_academica')->with('vendedor')->with('fuente_contacto')->where('leads.st_lead','A')->find($request->id);
    }
}
