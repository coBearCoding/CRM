<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\Llamadas;
use App\Empresa;
use App\Sede;
use App\Profile;
use App\NivelPrimario;
use App\PermisosNPrimario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp\Client;


class LlamadasController extends Controller
{
	protected $objinfoUser;

    public function __construct() {
		$this->middleware('configure');
        $this->middleware(function ($request, $next){
            $this->objinfoUser = Session::get('infoUser');
            return $next($request);
        });
	}

	public function index(){
       /*
        $ofertaAcademicaAll = [];
        if (!empty($this->objinfoUser->user_id)) {
            $ofertaAcademicaAll = PermisosNPrimario::with('nprimario')->where('user_id',$this->objinfoUser->user_id)->get();
        }


		$campanas = [];
		if (!empty($this->objinfoUser->sede_id)) {
			$campanas = Campana::where('estado','A')->where('sede_id',$this->objinfoUser->sede_id)->get();
		}else{
			$campanas = Campana::where('estado','A')->get();
		}

        $nivel_primario = NivelPrimario::where('estado','A')->get();
        $fuente_contactos = FuentesContacto::where('estado','A')->get();
        $medio_gestion = MediosGestion::where('estado', 'A')->get();
        $estado_comercial = EstadoComercial::where('tipo', 'L')->get();
        $estado_comercial_seguimientos = EstadoComercial::where('tipo', 'S')->get();
        $tipo_estudiante = TipoEstudiante::all();
        $procedencias = Procedencia::all();
        $Mailings = Mailing::all();
        $otrosProgramas = NivelSecundario::all();
       
        return view('leads.index',compact('campanas','nivel_primario','fuente_contactos','medio_gestion','tipo_estudiante','procedencias','Mailings','estado_comercial','estado_comercial_seguimientos','otrosProgramas','ofertaAcademicaAll'));
        */
        $sede = Sede::where('estado', 'A')->get();
        return view('reportes.llamadas',compact('sede'));
	}
	
	public function nivel(Request $request)
		   {
		   	$id=$request->id;

		   	$nivel=NivelPrimario::where('estado', 'A')->get();

           // var_dump($agente); exit;
           return response()->json([$nivel]);
	}



	public function asesor(Request $request)
		   {
		   	$id=$request->id;

		   	//cuando selecciona una sede en especifico 
		   	/*$asesor=DB::table('users')
		   	->select ('users.id','users.name')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('profiles.sede_id', $id)
            ->get();*/

            //cuando selecciona un nivel en especifico 
		   	$asesor=DB::table('users')
		   	->select ('profiles.extension','users.name')
            ->leftJoin('permisos_nprimario', 'users.id', '=', 'permisos_nprimario.user_id')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('permisos_nprimario.nprimario_id', $id)
            ->get();



           // var_dump($agente); exit;
           return response()->json([$asesor]);
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
                'trama_login_ws'=>'{"agentnumber" : "'.$this->objinfoUser->extension.'","agentpassword" : "'.$this->objinfoUser->extension.'","agentname" :"SIP/'.$this->objinfoUser->extension.'","extension" :"'.$this->objinfoUser->extension.'"}'
            ];

            $response  = $client->request('POST','/modules/redlinks_ws/RestControllerWS.php/agentlogin',[
                'form_params' => $form_params
            ]);

            //$response = json_decode($response->getBody(), true);

            //print_r($response);

        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            return response()->json(['msg' => 'error', 'data' => 'No se puede conectar al servidor de elastix. '.$e->getMessage() ]); 
        }
    }

      public function reporte(Request $request)
    {	

    	if($request->sedes=='-1'){
    		$sedes='';
    	}else{
    		$sedes=$request->sedes;
    	}

    	if($request->nivel=='-1'){
    		$nivel='';
    	}else{
    		$nivel=$request->nivel;
    	}

    	if($request->asesor=='-1'){
    		$asesor='';
    	}else{
    		$asesor='SIP/'.$request->asesor;
    	}

    	if($request->estado=='-1'){
    		$estado='';
    	}else{
    		$estado=$request->estado;
    	}
    	
        try {
            if (empty($request->fecha_ini)) {
                return response()->json(['msg' => 'error', 'data' => 'Seleccione fecha de Inicio' ]); 
            }

            if (empty($request->fecha_fin)) {
                return response()->json(['msg' => 'error', 'data' => 'Seleccione fecha de Fin' ]); 
            }
            
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
                'trama_param_report_ws'=>'{"start_date" :"'.$request->fecha_ini.'","end_date" :"'.$request->fecha_fin.'","agent":"'.$asesor.'","status":"'.$estado.'"}'
            ];

            $response  = $client->request('POST','/modules/redlinks_ws/RestControllerWS.php/param_report',[
                'form_params' => $form_params
            ]);

            $empresa = Empresa::find(1);
            $datos= json_decode($response->getBody(), true);
            
            return Excel::download(new Llamadas($datos,$empresa), "rpt_llamadas.xlsx");
           

        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            return response()->json(['msg' => 'error', 'data' => 'No se puede conectar al servidor de elastix. '.$e->getMessage() ]); 
        }
    }
}
