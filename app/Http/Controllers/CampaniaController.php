<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Campana;
use App\Sede;
use App\Periodo;
use App\Profile;
use App\NivelPrimario;
use App\NivelSecundario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\CampanasUsers;
use App\CampanasProgramas; 
use App\CampanasSede; 
use App\Metas;
//use Validator;
//use Illuminate\Contracts\Validation\Validator;

class CampaniaController extends Controller
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
    public function viewListaCampania(){
        
        return view('campania.listaCampania');
    }

    public function tblListaCampania(Request $request){
        $objinfoUser = Session::get('infoUser');

        $sql= " SELECT a.id,a.nombre , a.fecha_inicio, a.fecha_fin, a.estado,
                CASE 
                    when getdate() >= fecha_inicio AND  getdate() <= fecha_fin THEN 'Activa'
                    when fecha_fin > getdate() THEN 'Próximo' 
                    when fecha_fin < getdate() THEN 'Cerrado'
                    END AS apertura,
                    CASE 
                    when getdate() >= fecha_inicio AND  getdate() <= fecha_fin THEN 'badge badge-success'
                    when fecha_fin > getdate() THEN 'badge badge-warning' 
                    when fecha_fin < getdate() THEN 'badge badge-danger' 
                    END AS colorApertura,
                 
                 STUFF(
                    (SELECT ', '  + c.nombre 
                    FROM nivel_primario as c
                    LEFT  JOIN nivel_secundario as d  ON d.nprimario_id=c.id
                    LEFT  JOIN campana_programa as e  ON e.nsecundario_id=d.id
                    WHERE e.campana_id = a.id  GROUP BY c.nombre
                    FOR XML PATH('')),
                    1, 2, '') As nombre_oferta_academica 
                FROM campana as a 
                where a.empresa_id=".$objinfoUser->empresa_id."
                order by a.id desc";
       
        //$listaCampania = DB::select("exec sp_lista_campania ?" , array($objinfoUser->empresa_id));
        $listaCampania = DB::select($sql);
        return view('campania.tblListaCampania',['listaCampania'=>$listaCampania]); 
    }

    public function nsecundario(Request $request){
        //$request->codigo;
        $nsecundario =  DB::table('campana_programa')->select('nivel_secundario.nombre as nombre')
                        ->leftJoin('nivel_secundario', 'campana_programa.nsecundario_id', '=', 'nivel_secundario.id')
                        ->where('campana_programa.campana_id',$request->codigo)->where('campana_programa.estado','A')->get();
        return $nsecundario;

    }

    public function formularioCampana(){
        $cmbNivel1 = NivelPrimario::where('estado', '=', 'A')->get();
        $cmbSede = Sede::where('estado', '=', 'A')->get();
        $returnHTML = view('campania.formCampania')->render(); 
        $cmbMetas = Metas::where('estado', '=', 'A')->get();
        $cmbPeriodo = Periodo::where('estado', 'A')->get();
        $datos = array($cmbSede,$cmbNivel1,$cmbMetas,$cmbPeriodo);
        
        return response()->json(array('html'=>$returnHTML,'datos'=>$datos));
    }

    public function cmbNivel2(Request $request){
       
        $cmbNivel2 = NivelSecundario::where('nprimario_id', '=', $request->cod_nivel1)->where('estado', '=', 'A')->get();
       
        return $cmbNivel2;
    }

    public function nuevaCampana(Request $request){
     
 $objinfoUser = Session::get('infoUser');
        $mensaje = ['nom_campana.required' => 'Ingrese el nombre',
                    'fch_inicio.required' => 'Ingrese la fecha de Inicio',
                    
                    'fch_fin.required' => 'Ingrese la Fecha de Finalización',
                    'fch_fin.after_or_equal' => 'La Fecha de Finalización debe de ser mayor que la Fecha de Inicio',
                    'nom_contacto.required' =>'Ingrese el Nombre del Contacto',
                   // 'sede.required' => 'La Sede es Obligatorio',
                  
                    'email_contacto.required'=>'Ingresar un correo',
                    'email_contacto.email'=>'Ingrese un correo valido',
                    

        ]; 
        $validacion = Validator::make($request->all(), [
                'nom_campana' => 'required',
                'fch_inicio'  => 'required',
                'fch_fin' => 'required|after_or_equal:fch_inicio',
                'nom_contacto'  => 'required',
                //'sede'  => 'required',
               
                'email_contacto'=> 'required|email',
                
                
                ], $mensaje);
        if($validacion->fails()){
            $error=$validacion->errors();
           // var_dump($error); exit;
           return array('mensaje'=>$error,'clase'=>'error','opcion'=>'validar');
        }
        $programa= explode(',',$request->nivel2);
        $vendedor= explode(',',$request->vendedor);

        if(!empty($request->cod_campana)){
         
                 $count = Campana::where('nombre',$request->nom_campana)->where('estado','A')->where('id','!=',$request->cod_campana)->count();

            if($count==0){
                if(Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2){ //administrador o super admin
                    $campana = Campana::find($request->cod_campana);
                    $campana->nombre=$request->nom_campana;
                    $campana->op_asesor =$request->op_asesor; 
                    $campana->fecha_inicio=$request->fch_inicio;
                    $campana->fecha_fin=$request->fch_fin;
                    $campana->estado=$request->estadoCampana;

                    //$campana->sede_id=$request->sede;
                    $campana->empresa_id=$objinfoUser->empresa_id;
                    $campana->detalle=$request->detalle;
                    $campana->correo=$request->email_contacto;
                    $campana->ncontacto=$request->nom_contacto;
                    $campana->estado=$request->estadoCampana;
                    $campana->meta_id= $request->meta;
                    $campana->fecha_creacion=date('Y-m-d h:i:s');
                    $campana->user_id=$objinfoUser->user_id;
                    $campana->save();
                }
                
                $ult_reg = Campana::where('estado','A')->orderBy('id', 'desc')->first(); 
                //CampanasSede::where('campana_id',$request->cod_campana)->delete(); 
                 CampanasSede::where('campana_id',$request->cod_campana)->update(['estado'=>'I']);
                if($request->sede=="T"){
                    $sede= Sede::where('estado','A')->get();
                    
                    foreach ($sede as $value) {

                        $cont_sede = CampanasSede::where('campana_id',$request->cod_campana)->where('sede_id',$value->id)->count();
                        if($cont_sede>0){
                           CampanasSede::where('campana_id',$request->cod_campana)->where('sede_id',$value->id)->update(['estado'=>'A']); 
                        }else{
                            $campana_sede= new CampanasSede();
                            $campana_sede->sede_id=$value->id;
                            $campana_sede->campana_id=$request->cod_campana;
                            $campana_sede->estado='A';
                            $campana_sede->save();
                        }
                    }
                    
                }else{
                     $cont_sede = CampanasSede::where('campana_id',$request->cod_campana)->where('sede_id',$request->sede)->count();
                        if($cont_sede>0){
                           CampanasSede::where('campana_id',$request->cod_campana)->where('sede_id',$request->sede)->update(['estado'=>'A']); 
                        }else{
                        $campana_sede= new CampanasSede();
                        $campana_sede->sede_id=$request->sede;
                        $campana_sede->campana_id=$request->cod_campana;
                        $campana_sede->estado='A';
                        $campana_sede->save();
                    }
                }
              //  $eliminacion_prog=CampanasProgramas::where('campana_id',$request->cod_campana)->delete(); 
                //var_dump($eliminacion_prog); exit;
                $desactivar_prog=CampanasProgramas::where('campana_id',$request->cod_campana)->update(['estado'=>'I']); 
                for($a=0; $a< count($programa); $a++){
                    if($programa[$a] !='TODO'){
                       $cont_camp_prog = CampanasProgramas::where('campana_id',$request->cod_campana)->where('nsecundario_id',$programa[$a])->count();
                       if($cont_camp_prog>0){
                             $desactivar_prog=CampanasProgramas::where('campana_id',$request->cod_campana)->where('nsecundario_id',$programa[$a])->update(['estado'=>'A']);
                       }else{
                           $campana_programa = new CampanasProgramas();
                           $campana_programa->campana_id= $request->cod_campana;
                           $campana_programa->nsecundario_id=$programa[$a];
                           $campana_programa->estado='A';
                           $campana_programa->save();
                       }
                    } 

                }
               //$eliminacion_user=CampanasUsers::where('campana_id',$request->cod_campana)->delete(); 
                   $eliminacion_user=CampanasUsers::where('campana_id',$request->cod_campana)->update(['estado'=>'I']); 
                for($a=0; $a< count($vendedor); $a++){
                    if($vendedor[$a] != 'TODO'){
                        $cont_user = CampanasUsers::where('campana_id',$request->cod_campana)->where('user_id',$vendedor[$a])->count();
                       if($cont_user>0){
                        CampanasUsers::where('campana_id',$request->cod_campana)->where('user_id',$vendedor[$a])->update(['estado'=>'A']);
                       }else{
                       $campana_asesor = new CampanasUsers();
                       $campana_asesor->campana_id= $request->cod_campana;
                       $campana_asesor->user_id=$vendedor[$a];
                       $campana_asesor->estado='A';
                       $campana_asesor->save();
                        }
                    }

                }

                return array('mensaje'=>'Felicitaciones!! El registro de la Campaña se guardo exitosamente','clase'=>'success','opcion'=>'final');
            }else{
                return array('mensaje'=>'Error!! Este nombre ya se encuentra registrado en la Base de datos','clase'=>'error','opcion'=>'final');

            } 

           /* $ingCampana= Campana::modCampana(  $request->cod_campana,
                                                $request->cod_periodo,
                                                $request->nom_campana,
                                                $request->fch_inicio,
                                                $request->fch_fin,
                                                $request->nom_contacto,
                                                $request->email_contacto,
                                                $request->sede,
                                                $request->nivel1,
                                                $request->nivel2,
                                                $request->detalle,
                                                $request->estadoCampana,
                                                $request->meta);*/
        }else{
            $count = Campana::where('nombre',$request->nom_campana)->where('estado','A')->count();

            if($count==0){

                
                if(Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2){ //administrador o super admin
                     
                $campana = new Campana();
                $campana->nombre=$request->nom_campana;
                $campana->op_asesor =$request->op_asesor;
                $campana->fecha_inicio=$request->fch_inicio;
                $campana->fecha_fin=$request->fch_fin;
                $campana->estado=$request->estadoCampana;
                //$campana->sede_id=$request->sede;
                $campana->empresa_id=$objinfoUser->empresa_id;
                $campana->detalle=$request->detalle;
                $campana->correo=$request->email_contacto;
                $campana->ncontacto=$request->nom_contacto;
                $campana->estado=$request->estadoCampana;
                $campana->periodo_id=$request->cod_periodo;
                $campana->meta_id= $request->meta;
                $campana->fecha_creacion=date('Y-m-d h:i:s');
                $campana->user_id=$objinfoUser->user_id;
                $campana->save();
               
                $ult_reg = Campana::where('estado','A')->orderBy('id', 'desc')->first(); 
                //CampanasSede::where('campana_id',$ult_reg->id)->delete(); 
                if($request->sede=="T"){
                    $sede= Sede::where('estado','A')->get();
                    
                    foreach ($sede as $value) {
                        $campana_sede= new CampanasSede();
                        $campana_sede->sede_id=$value->id;
                        $campana_sede->campana_id=$ult_reg->id;
                         $campana_sede->estado='A';
                        $campana_sede->save();
                    }
                    
                }else{
                        $campana_sede= new CampanasSede();
                        $campana_sede->sede_id=$request->sede;
                        $campana_sede->campana_id=$ult_reg->id;
                         $campana_sede->estado='A';
                        $campana_sede->save();
                }
                //CampanasProgramas::where('campana_id',$ult_reg->id)->delete(); 
                for($a=0; $a< count($programa); $a++){
                   if($programa[$a] !='TODO'){
                       $campana_programa = new CampanasProgramas();
                       $campana_programa->campana_id= $ult_reg->id;
                       $campana_programa->nsecundario_id=$programa[$a];
                       $campana_programa->estado='A';
                       $campana_programa->save();
                    }

                }
             //   CampanasUsers::where('campana_id',$ult_reg->id)->delete(); 
                for($a=0; $a< count($vendedor); $a++){
                    if($vendedor[$a] !='TODO'){
                       $campana_asesor = new CampanasUsers();
                       $campana_asesor->campana_id= $ult_reg->id;
                       $campana_asesor->user_id=$vendedor[$a];
                       $campana_asesor->estado='A';
                       $campana_asesor->save();
                    }
                }
                return array('mensaje'=>'Felicitaciones!! El registro de la Campaña se actualizo exitosamente','clase'=>'success','opcion'=>'final');


                }else{
                    return array('mensaje'=>'Error!!Usted no tiene permisos para ingresar una nueva Campaña','clase'=>'error','opcion'=>'final');
                }
            }else{
                return array('mensaje'=>'Error!! Este nombre ya se encuentra registrado en la Base de datos','clase'=>'error','opcion'=>'final');

            }
           // var_dump($count); exit;
            /*$ingCampana= Campana::nuevaCampana($request->cod_periodo,
                                                $request->nom_campana,
                                                $request->fch_inicio,
                                                $request->fch_fin,
                                                $request->nom_contacto,
                                                $request->email_contacto,
                                                $request->sede,
                                                $request->nivel1,
                                                $request->nivel2,
                                                $request->detalle,
                                                $request->estadoCampana,
                                                $request->meta);*/
        }
       
        
    }

    public function formularioCampanaEditar(Request $request){

    try{

        $nv_primario=0;
        $meta=0;
        $objinfoUser = Session::get('infoUser');
        $infCampana=Campana::find($request->cod_campana);//selecciona el cmb_sede seleccionado
        $meta=Metas::where('estado','A')->get();
        $campana_programas= CampanasProgramas::where('campana_id',$infCampana->id)->where('estado','A')->get(); //selecciona todos los programas seleccionados
        foreach ($campana_programas as $key ) {
            $programa=$key->nsecundario_id;
        }
        if(!isset($programa)){$programa=' ';}
        $nv_primario_sel = NivelSecundario::where('estado', '=', 'A')->where('id',$programa)->get();// selecciono el nivel primario
        foreach ($nv_primario_sel as $key ) {
            $nv_primario=$key->nprimario_id;
        }
      
        $asesor =  CampanasUsers::where('campana_id',$infCampana->id)->where('estado','A')->get(); 
        
        $cmbNivel2 = NivelSecundario::where('estado', '=', 'A')->where('nprimario_id',$nv_primario)->get();//todos nivel secundario
        
        $cmbNivel1 = NivelPrimario::where('estado', '=', 'A')->get();// Todos nivel primario
         if($infCampana->op_asesor =='V'){
            $filtro=" AND d.asesor_nprimario='SI'";
        }else{
            $filtro=" ";
        }

        $camp_sede =  CampanasSede::where('campana_id',$infCampana->id)->where('estado','A')->get();
        $todas_sedes = "(";
        foreach ($camp_sede as $key => $sed) {
            if($key == 0){
              $todas_sedes .= $sed->sede_id;  
            } else {
              $todas_sedes .= ",".$sed->sede_id;  
            }
        }
          $todas_sedes .= ")";
        if(count($camp_sede)>1){
            $filtro .=" and b.sede_id in ".$todas_sedes . " or b.sede_id is null ";
        }else if(count($camp_sede)==1){
            foreach ($camp_sede as $value) {
               $filtro .=" and b.sede_id=".$value->sede_id; 
            }
            
        } 
        $cmbPeriodo = Periodo::where('estado', 'A')->get();
        $cmbAsesor = DB::select("exec sp_cmb_asesor ?,?,?" , array($objinfoUser->empresa_id,$nv_primario,$filtro)); //todos los vendedores
        
        $cmbSede = Sede::where('estado', '=', 'A')->get(); // toda la sede
      
        $returnHTML = view('campania.formCampania')->render(); 
        $datos = array($cmbSede,$cmbNivel1,$infCampana,$nv_primario,$cmbNivel2,$asesor,$cmbAsesor,$campana_programas,$meta,$camp_sede,$cmbPeriodo);
        return response()->json(array('html'=>$returnHTML,'datos'=>$datos));

       } catch (\Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
       }
    }   

    public function eliminarCampana(Request $request){
        $campana=Campana::find($request->cod_campana);
        $campana->estado = 'I';
        $campana->save();
        return 'Se ha eliminado correctamente la Campaña ';
    }

    public function cmbAsesor(Request $request){
        $nivel1 = $request->nivel1;
        $sede = $request->sede;
        $opcion = $request->op_asesor;
        if(!empty($nivel1) && !empty($sede) && !empty($opcion) ){
            $objinfoUser = Session::get('infoUser');

            if($opcion=='V'){
                $filtro=" AND d.asesor_nprimario='SI'";
            }else{
                $filtro="";
            }

            if($sede=='T'){
                //$filtro .=" and b.sede_id is not null";
                $filtro .=" ";
            }else{
                $filtro .=" and b.sede_id=".$sede;
            }
            $cmbAsesor = DB::select("exec sp_cmb_asesor ?,?,?" , array($objinfoUser->empresa_id,$nivel1,$filtro));
        }else{
            $cmbAsesor="";
        }
        return $cmbAsesor;

    }  
}
    

