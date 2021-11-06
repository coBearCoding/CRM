<?php

namespace App\Http\Controllers;

use App\Plantillas;
use App\Roles;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Campana;
use App\Empresa;
use App\Mailing;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Session;

class PlantillasController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('configure');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $objinfoUser = Session::get('infoUser');
        //$lstDatos = Campana::where('estado', 'A')->where('empresa_id', $objinfoUser->empresa_id)->get();
        $sql="SELECT *
                    FROM campana 
                    where  getdate() >= fecha_inicio AND  getdate() <= fecha_fin
                    and  estado !='I'  AND  empresa_id=".$objinfoUser->empresa_id." 
                    order by id desc";
        $lstDatos = DB::select($sql);           
        return view('plantillas.index',['lstDatos'=>$lstDatos]);
    }

    public function plantilla(){
        $objinfoUser = Session::get('infoUser');
        $empresa = Empresa::find($objinfoUser->empresa_id);
        //lstDatos = Campana::where('estado', 'A')->where('empresa_id', $objinfoUser->empresa_id)->get();
        $sql="SELECT *
                    FROM campana 
                    where  getdate() >= fecha_inicio AND  getdate() <= fecha_fin
                    and  estado ='A'  AND  empresa_id=".$objinfoUser->empresa_id." 
                    order by id desc";
        $lstDatos = DB::select($sql); 
        return view('plantillas.plantilla',['lstDatos'=>$lstDatos,'url_sitio'=>$empresa->url_sitio]);
    }

    public function imagen_archivo(Request $request){

        $objinfoUser = Session::get('infoUser');
        $empresa = Empresa::find($objinfoUser->empresa_id);

        $path= public_path().'/empresa/'.$empresa->nombre.'/imagenes/'; 
        if(!File::exists($path)) { 
            File::makeDirectory($path, 0777, true, true);
        } 
        $max_size =(int)ini_get('upload_max_filesize') *10240;
        $file=$request->file('file');
        if($request->hasFile('file')){
            //$file_name= $request->file('archivo_tarea').'_'.date('Y-m-d-H:i:s').'.'.$file->getClientOriginalExtension();
            $file_name=pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME).'_'.date('YmdHis'); 
            $file_name=$file_name.'.'.$file->getClientOriginalExtension();
            $file->move($path,$file_name);
          
        }

    }

    public function ultimo_archivo(Request $request){
        $objinfoUser = Session::get('infoUser');
        $empresa = Empresa::find($objinfoUser->empresa_id);
        $path=public_path().'/empresa/'.$empresa->nombre.'/imagenes/'; 
        $dir= $empresa->url_sitio.'/empresa/'.$empresa->nombre.'/imagenes/'; 
        chdir($path);
        array_multisort(array_map('filemtime', ($files = glob("*.*"))), SORT_ASC, $files);
        foreach($files as $filename){}
        return $dir.$filename;
      
    }

    public function guardarPlantilla(Request $request){
        try{
            if(!empty($request->codigo)){
                $mensaje = ['nombre.required' => 'Ingrese el nombre',
                        'nombre.unique' => 'Este nombre ya se encuentra utilizado',
                ]; 
                $validacion = Validator::make($request->all(), [
                        'nombre' => 'required|unique:mailing,nombre,'.$request->codigo,
                 ], $mensaje);
                if($validacion->fails()){
                    $error=$validacion->errors();
                   // var_dump($error); exit;
                   return array('mensaje'=>$error,'clase'=>'error','opcion'=>'validar');
                }

                $objinfoUser = Session::get('infoUser');
                $empresa = Empresa::find($objinfoUser->empresa_id);
                $path= public_path().'/empresa/'.$empresa->nombre.'/plantilla/'; 
                $plantilla= Mailing::find($request->codigo);
                $path2= public_path().'/empresa/'.$empresa->nombre.'/plantilla/'.$plantilla->nombre;
                if(File::exists($path2)) { 
                    File::delete($path2);
                }

                if(!File::exists($path)) { 
                    File::makeDirectory($path, 0777, true, true);
                } 

                
                $titulo             = $request->nombre;
                $contenido_expo     ='<!doctype html><head><meta charset="UTF-8"></head><title>Form Preview</title><body class="container"><h1>Vista Previa</h1><hr>'.$request->contenido_expo.'</body></html>';
                $contenido_expo     = ($contenido_expo);
                file_put_contents($path.$titulo.'.html',$contenido_expo);
                $plantilla= Mailing::find($request->codigo);
                $plantilla->nombre= $titulo;
                $plantilla->cont_plantilla=$request->contenido;
                $plantilla->fecha_creacion=date('Y-m-d h:i:s');
                $plantilla->user_id=$objinfoUser->id;
                $plantilla->empresa_id=$objinfoUser->empresa_id;
                $plantilla->estado='A';
                $plantilla->campana_id=$request->cmb_campana;
                $plantilla->opcion='C';
                $plantilla->save();   
                return array('mensaje'=>'Se guardo correctamente','clase'=>'sucess','opcion'=>'no');

            }else{ 

                $mensaje = ['nombre.required' => 'Ingrese el nombre',
                        'nombre.unique' => 'Este nombre ya se encuentra utilizado',
                ]; 
                $validacion = Validator::make($request->all(), [
                        'nombre' => 'required|unique:mailing,nombre',
                 ], $mensaje);
                if($validacion->fails()){
                    $error=$validacion->errors();
                   // var_dump($error); exit;
                   return array('mensaje'=>$error,'clase'=>'error','opcion'=>'validar');
                }   
                $objinfoUser = Session::get('infoUser');
                $empresa = Empresa::find($objinfoUser->empresa_id);
                $path= public_path().'/empresa/'.$empresa->nombre.'/plantilla/'; 
                if(!File::exists($path)) { 
                    File::makeDirectory($path, 0777, true, true);
                } 
                $titulo             = $request->nombre;
                $contenido_expo     ='<!doctype html><head><meta charset="UTF-8"></head><title>Form Preview</title><body class="container"><h1>Vista Previa</h1><hr>'.$request->contenido_expo.'</body></html>';
                $contenido_expo     = ($contenido_expo);
                file_put_contents($path.$titulo.'.html',$contenido_expo);
                $plantilla= new Mailing();
                $plantilla->nombre= $titulo;
                $plantilla->cont_plantilla=$request->contenido;
                $plantilla->fecha_creacion=date('Y-m-d h:i:s');
                $plantilla->user_id=$objinfoUser->id;
                $plantilla->empresa_id=$objinfoUser->empresa_id;
                $plantilla->estado='A';
                $plantilla->campana_id=$request->cmb_campana;
                $plantilla->opcion='C';
                $plantilla->save(); 
                return array('mensaje'=>'Se guardo correctamente','clase'=>'sucess','opcion'=>'no');
            }

        } catch (Exception $e) {
            
            return array('mensaje'=> $e->getMessage(),'clase'=>'error','opcion'=>'no');
        }

     }
   
   public function tblListaPlantilla(Request $request){
    $objinfoUser = Session::get('infoUser');
    $sql = "select m.id , m.nombre, c.nombre as nom_campana, m.estado from mailing as m 
                                left join campana as c on c.id=m.campana_id
                                
                                where m.estado='A' and m.empresa_id=" . $objinfoUser->empresa_id;

    $listPlantilla = DB::select($sql);
   // $listPlantilla = Mailing::where('estado','A')->where('empresa_id', $objinfoUser->empresa_id)->get();

    return view('plantillas.tabla',['listPlantilla'=>$listPlantilla]);

   }

   public static function delete(Request $request){
    $plantilla = Mailing::find($request->codigo);
    $plantilla->estado='I';
    $plantilla->save();
    return 'Se ha eliminado correctamente la Plantilla';

   }

   public static function preview(Request $request){
        $objinfoUser = Session::get('infoUser');
        $empresa = Empresa::find($objinfoUser->empresa_id);
        $plantilla = Mailing::find($request->codigo);
        $path= public_path().'/empresa/'.$empresa->nombre.'/plantilla/'.$plantilla->nombre.'.html'; 
        if(File::exists($path)) { 
            $ruta=$empresa->url_sitio.'/empresa/'.$empresa->nombre.'/plantilla/'.$plantilla->nombre.'.html';
            $respuesta = array('ruta' => $ruta,'archivo'=>'ok');
            return  $respuesta;
        }else{
            if($plantilla->opcion=='I'){
                $asesor='';
                $nombre_lead='';
                $imagen_carrera=$plantilla->cont_plantilla;
                $html = view('mailing.plantilla', compact('asesor', 'nombre_lead', 'imagen_carrera'))->render(); 
               return response()->json(array('html'=>$html,'archivo'=>'no'));
            }else{
               return response()->json(array('html'=>$plantilla->cont_plantilla,'archivo'=>'no'));
           
            }
            
        } 

   }

   public function plantillaeditar(Request $request){
            
     $objinfoUser = Session::get('infoUser');
     $plantilla= Mailing::where('id',$request->codigo)->with('campana')->get();
     //var_dump($plantilla); exit;
        $empresa = Empresa::find($objinfoUser->empresa_id);
        $lstDatos = Campana::where('estado', 'A')->where('empresa_id', $objinfoUser->empresa_id)->get();
        return view('plantillas.mod-plantilla',['lstDatos'=>$lstDatos,'url_sitio'=>$empresa->url_sitio,'plantilla'=>$plantilla]);

   } 

    
}
