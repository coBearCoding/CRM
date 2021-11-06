<?php

namespace App\Http\Controllers;
 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Campana;
use App\CampanasProgramas;
use App\Sede;
use App\Profile;
use App\NivelPrimario;
use App\NivelSecundario;
use App\FuentesContacto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Contacto;
use App\TipoContacto;
use App\ContactoHistorico;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth; 
use App\AuditoriaContacto; 
use App\Imports\ClientesImport;
use App\Imports\LeadsImport;
use App\Procedencia;

//use Validator;
//use Illuminate\Contracts\Validation\Validator;

class ImportarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function importar(){
        $cmbNivel1 = NivelPrimario::where('estado', '=', 'A')->get();
        $cmbSede = Sede::where('estado','A')->get();
        $cmbCampana = Campana::where('estado','A')->get();
        $cmbProcedencia = Procedencia::all();
        
        $cmbFteContacto = FuentesContacto::where('estado','A')->get();
        return view('importar.index',['cmbFteContacto'=>$cmbFteContacto,'cmbNivel1'=>$cmbNivel1,'cmbSede'=>$cmbSede,'cmbCampana'=>$cmbCampana,'cmbProcedencia'=>$cmbProcedencia]);
    }   
    
    public function importarDatos(Request $request){
       
        if( $opcion = $request->opcion=='L'){
            
            $mensaje = ['archivo.required' => 'Importar un archivo',
                        'archivo.mimes' => 'Formato del archivo xls,xlsx',   
                        'fte_contacto.required' => 'Seleccionar fuente de contacto',
                        'nom_campana.required' =>'Seleccionar la campaña',
                        
                        'nivel2.required' =>'Seleccionar el programa',
                        'sede.required' => 'Seleccionar una sede'
                        ]; 
            $validacion = Validator::make($request->all(), [
                    'archivo'=> 'required|mimes:xls,xlsx',
                    'fte_contacto'=>'required',
                    'nom_campana'=>'required',
                    
                    'nivel2'=>'required',
                    'sede'=>'required'
                    ], $mensaje);
            if($validacion->fails()){
                $error=$validacion->errors();
                
               return array('mensaje_error'=>$error,'clase'=>'alert-danger');
            }
            $path= $request->file('archivo')->getRealPath();
            $file =  $request->file('archivo');
           
            $fte_contacto = $request->fte_contacto;
            $cod_campana = $request->nom_campana;
            //$procedencia = $request->procedencia;
            
            $nivel2 = $request->nivel2;
            $sede = $request->sede;
            $cod_vendedor = '';

            $campana = Campana::find($cod_campana);
           // $name_campana= $name_campana->nom_campana;
            $objinfoUser = Session::get('infoUser');
            $cod_empresa=$objinfoUser->empresa_id;
            $dataimport = Excel::import(new LeadsImport($fte_contacto,$cod_campana,$nivel2,$sede, $cod_vendedor), $file);
            exit;
           // return  $dataimport;  
          
           
        }else if($opcion = $request->opcion=='C'){
            $nuevo=0;
            $actualizar=0;
            $error=0;
            $mensaje = ['archivo.required' => 'Importar un archivo',
                        'archivo.mimes' => 'Formato del archivo xls,xlsx',   
                        'nom_campana.required' =>'Seleccionar la campaña',
                        'nivel1.required' =>'Seleccionar la oferta Académica',
                        'nivel2.required' =>'Seleccionar el programa',
                        'sede.required' => 'Seleccionar una sede'
                        ]; 
            $validacion = Validator::make($request->all(), [
                    'archivo'=> 'required|mimes:xls,xlsx',
                    'nom_campana'=>'required',
                    'nivel1'=>'required',
                    'nivel2'=>'required',
                    'sede'=>'required'
                    ], $mensaje);
            if($validacion->fails()){
                $error=$validacion->errors();
                $respuesta =array('mensaje_error'=>$error,'clase'=>'alert-danger');
               return $respuesta;
            }
            $path= $request->file('archivo')->getRealPath();
            $file =  $request->file('archivo');
            $cod_campana = $request->nom_campana;
           // $procedencia = $request->procedencia;
            $nivel2 = $request->nivel2;
            $sede = $request->sede;
            $cod_vendedor = '';
            $cod_campana = $request->nom_campana;
            $campana = Campana::find($cod_campana);
            $objinfoUser = Session::get('infoUser');
            $cod_empresa=$objinfoUser->empresa_id;
            
            $dataimport = Excel::import(new ClientesImport($cod_campana,$nivel2,$sede, $cod_vendedor), $file);
            //return $dataimport;
            exit;
            
        }
    }

    public function cmbCampana(Request $request){

        if($request->cod_sede=='T'){
            $cod_sede=' ';
        }else{
            $cod_sede=' and (b.sede_id='.$request->cod_sede.' or a.sede_id='.$request->cod_sede.')';
        }

        $objinfoUser = Session::get('infoUser');
        $sql="select a.id, a.nombre from campana as a
        left join campana_sede as b on a.id=b.campana_id
        where getdate() >= a.fecha_inicio AND  getdate() <= a.fecha_fin and a.estado ='A' and empresa_id=".$objinfoUser->empresa_id.$cod_sede." Group by a.id, a.nombre";
        //var_dump($sql); exit;
        $cmbCampana = DB::select($sql); 
        return $cmbCampana;
      

       /* $objinfoUser = Session::get('infoUser');
        $sql="select a.id, a.nombre from campana as a
        left join campana_sede as b on a.id=b.campana_id
        where getdate() >= a.fecha_inicio AND  getdate() <= a.fecha_fin and a.estado ='A' and (b.sede_id=".$request->cod_sede." or a.sede_id=".$request->cod_sede.") and empresa_id=".$objinfoUser->empresa_id;
        //var_dump($sql); exit;
        $cmbCampana = DB::select($sql); 
        return $cmbCampana;*/
    } 

    public function cmbProgramas(Request $request){
        $cmbPrograma = CampanasProgramas::with('programa')->with('campana')
            ->where('campana_id', $request->codigo)->get();
        return $cmbPrograma;
    }

    public function cmbAsesor_campana(Request $request){
       //var_dump('ok');exit;
        $campana = $request->nom_campana;
        $opcion = $request->op_asesor;
        $nivel2_campana = $request->nivel2;
        $sedes  = $request->sedes;
       
        if(!empty($campana) && !empty($opcion) && !empty($nivel2_campana) ){
            $nivel2 = CampanasProgramas::where('id',$nivel2_campana)->first();
            $nivel1 = NivelSecundario::where('id',$nivel2->nsecundario_id)->first();
            
            if($opcion=='V'){
                $filtro=" AND e.campana_id=".$campana;
               
            }else{
                $filtro=" AND d.nprimario_id=".$nivel1->nprimario_id." and b.sede_id=".$sedes;
            }

            
            $cmbAsesor = DB::select("exec sp_cmb_asesor_campana ?" , array($filtro));
        }else{
            $cmbAsesor="";
        }
        return $cmbAsesor;

    } 


}
    

