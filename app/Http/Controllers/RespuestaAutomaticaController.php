<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Campana;
use App\Sede;
use App\Profile;
use App\NivelPrimario;
use App\RespuestaAutomaticaAdjuntoPrograma;
use App\NivelSecundario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\CampanasProgramas; 
use App\Formulario; 
use App\RespuestaAutomatica;
use App\RespuestaAutomaticaNsecundario;
use App\RespuestaAutomaticaAdjunto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;
//use Validator;
//use Illuminate\Contracts\Validation\Validator;

class RespuestaAutomaticaController extends Controller
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

    public function index(){
        $objinfoUser = Session::get('infoUser');
        $formulario = Formulario::where('estado','A')->where('empresa_id',$objinfoUser->empresa_id)->get();
        return view('rautomatica.listaRespuestaAutomatica',['formulario'=>$formulario]);
    }  

    public function wizardFormRespAuto(){
        $objinfoUser = Session::get('infoUser');
        $formulario = Formulario::where('estado','A')->where('empresa_id',$objinfoUser->empresa_id)->get();
        
        return view('rautomatica.formRespuestaAutomatica',['formulario'=>$formulario]);
    }

    public function opcionPlantilla(Request $request){
        $op_plantilla   = $request->op_plantilla;
        $form_id        = $request->form_plantilla;
        $objinfoUser = Session::get('infoUser');
        if(trim($op_plantilla)=='P'){
                $sql = "SELECT c.nombre as nom_mail,c.id as cod_mail FROM formularios as f
                        left join mailing as c on c.campana_id = f.campana_id
                        WHERE f.estado='A'  and c.estado='A'and f.id=".$form_id." and f.empresa_id=".$objinfoUser->empresa_id;
                $listMailing = DB::select($sql);

                $sql = "SELECT n.nombre as nom_nivel2,n.id as cod_nivel2 FROM formularios as f
                        left join campana_programa as c on c.campana_id = f.campana_id
                        left join nivel_secundario as n on n.id=c.nsecundario_id
                        WHERE f.estado='A'  and f.id=".$form_id." and f.empresa_id=".$objinfoUser->empresa_id;
                $listNivel2 = DB::select($sql);
                $datos =array($listMailing,$listNivel2);
                $vista= view('rautomatica.tblTab2',['listMailing'=>$listMailing,'listNivel2'=>$listNivel2,'form_id'=> $form_id,'op_plantilla'=>$op_plantilla,'tab'=>'list_mail'])->render(); 
                $vista_archivo= view('rautomatica.tblPrograma',['listNivel2'=>$listNivel2])->render(); 
                $vista_archivo="";

        }else{
            
                $sql = "SELECT  a.nombre, a.id  from mailing as a  
                        left join campana as b on a.campana_id= b.id
                        left join campana_programa as c on b.id= c.campana_id
                        where a.campana_id IS NULL OR  a.estado != 'I' and c.nsecundario_id=0";
                $mailing = DB::select($sql);
                $vista= view('rautomatica.tblTab2',['mailing'=>$mailing,'op_plantilla'=>$op_plantilla,'tab'=>'list_mail'])->render(); 
                $vista_archivo="";
                $listNivel2="";

        }
        return response()->json(array('listNivel2'=>$listNivel2,'html'=>$vista,'html_programa'=>$vista_archivo,'op_plantilla'=>$op_plantilla ));
    }

    public function datosGuardado(Request $request){
        try {
            DB::beginTransaction();
            $objinfoUser = Session::get('infoUser');
            $form_id= $request->plantilla;
            $nombre= $request->nombre;
            $asunto= $request->asunto;
            $op_plantilla= $request->op_plantilla;
            $cod_respuesta= $request->cod_respuesta;
            $respuestaAutomatica = RespuestaAutomatica::where('formulario_id',$form_id)->where('estado','A')->where('id',$cod_respuesta)->count();
            $contAutomatica = RespuestaAutomatica::where('formulario_id',$form_id)->where('estado','A')->where('id','!=',$cod_respuesta)->count();
            $contRespAuto = RespuestaAutomatica::where('formulario_id',$form_id)->where('estado','A')->count();
            if($contRespAuto >0 && $contAutomatica>0){
                return response()->json(array('datos'=>'Este fromulario ya tiene respuesta automática','opcion'=>'no'));
            }

            $archivos = $request->archivos;
            $programas = $request->programa_arc;
            $plantilla = $request->plantilla;
            $cod_respuesta = $request->cod_respuesta;
            $op_plantilla   = $request->op_plantilla;
            $respAutoNS = RespuestaAutomaticaNsecundario::where('resp_auto_id',$cod_respuesta)->get();
            if(!empty($respAutoNS)){
                $respAutoNS = DB::table('respuesta_automatica_nsecundario')->where('resp_auto_id',$cod_respuesta)->delete();
            }
            $respAutoAdj = RespuestaAutomaticaAdjunto::where('resp_auto_id',$cod_respuesta)->get();

            if(!empty($respAutoAdj)){
                foreach ($respAutoAdj as $value) {
                     $respAutoAdj = DB::table('respuesta_automatica_adjunto_nsecundario')->where('resp_auto_adj_id',$value->id)->delete();
                }
                 $respAutoAdj = DB::table('respuesta_automatica_adjunto')->where('resp_auto_id',$cod_respuesta)->delete();
            }

            $archivo = explode(",",$archivos);
            $programa_adj = explode(",",$programas);

            if($op_plantilla=="P"){
                    $programa2 = $request->programa2;
                    $progP = explode(",",$programa2);
                    $programa = $request->programa;
                    if(count($progP) > count(array_unique($progP))){
                      return ['datos'=>'Varias carreras se encuentra en diferentes plantillas','opcion'=>'no'];
                    }
            }

            if($respuestaAutomatica ==0 ){

                $resp_auto = new RespuestaAutomatica();
                $resp_auto->formulario_id = $form_id;
                $resp_auto->nombre = $nombre;
                $resp_auto->asunto = $asunto;
                $resp_auto->resp_auto_tipo = $op_plantilla;
                $resp_auto->user_id = $objinfoUser->id;
                $resp_auto->empresa_id = $objinfoUser->empresa_id;
                $resp_auto->estado = 'A';
                $resp_auto->save();
                if($op_plantilla=="P"){
                    /*$programa2 = $request->programa2;
                    $progP = explode(",",$programa2);
                    $programa = $request->programa;
                    if(count($progP) > count(array_unique($progP))){
                      return ['datos'=>'Varias carreras se encuentra en diferentes plantillas','opcion'=>'no'];
                    }else{*/
                        $prog = explode(",",$programa);
                        $prog0= [];
                        for ($i=0; $i < count($prog) ; $i++) { 
                            $prog0[$i]= explode("_",$prog[$i]);
                        }
                       //var_dump($prog0); exit;
                        for($k=0; $k<count($prog0); $k++){
                            $resp_auto_nivel = new RespuestaAutomaticaNsecundario();
                            $resp_auto_nivel->nsecundario_id=$prog0[$k][0];
                            $resp_auto_nivel->mailing_id=$prog0[$k][1];
                            $resp_auto_nivel->resp_auto_id=$resp_auto->id;
                            $resp_auto_nivel->estado='A';
                            $resp_auto_nivel->empresa_id=$objinfoUser->empresa_id;
                            $resp_auto_nivel->user_id=Auth::user()->id;
                            $resp_auto_nivel->fecha_creacion = date('Y-m-d h:i:s');
                           $resp_auto_nivel->save();
                        }

                        if(!empty($archivos)){
                            for($j=0; $j<count($archivo); $j++){

                                $resp_auto_arch = new RespuestaAutomaticaAdjunto();
                                $resp_auto_arch->nombre=$archivo[$j];
                                $resp_auto_arch->resp_auto_id=$resp_auto->id;
                                $resp_auto_arch->estado='A';
                                $resp_auto_arch->empresa_id=$objinfoUser->empresa_id;
                                $resp_auto_arch->user_id=Auth::user()->id;
                                $resp_auto_arch->fecha_creacion = date('Y-m-d h:i:s');
                                $resp_auto_arch->save();
                                $path= public_path().'/files/'.$resp_auto->id.'/'; 
                                //var_dump($path); exit;
                                   // $path= public_path().'/files/11/'; 
                                if(!File::exists($path)) { 
                                        File::makeDirectory($path, 0777, true, true);
                                } 
                                rename(public_path().'/files/'.$archivo[$j], $path.$archivo[$j]); 
                                $resp_auto_arch_prog = new RespuestaAutomaticaAdjuntoPrograma();
                                $resp_auto_arch_prog->resp_auto_adj_id=$resp_auto_arch->id;
                                $resp_auto_arch_prog->resp_auto_adj_nsecu_id=$programa_adj[$j];
                                $resp_auto_arch_prog->save();

                            }
                        }
                         DB::commit();
                        return ['datos'=>'Registro completado ','opcion'=>'ok'];
                    //}
                }else{
                    $mailing = $request->mailing;
                    $resp_auto_nivel = new RespuestaAutomaticaNsecundario();
                    $resp_auto_nivel->mailing_id=$mailing;
                    $resp_auto_nivel->resp_auto_id=$resp_auto->id;
                    $resp_auto_nivel->estado='A';
                    $resp_auto_nivel->empresa_id=$objinfoUser->empresa_id;
                    $resp_auto_nivel->user_id=Auth::user()->id;
                    $resp_auto_nivel->fecha_creacion = date('Y-m-d h:i:s');
                    $resp_auto_nivel->save();
                    if(!empty($archivos)){
                        for($j=0; $j<count($archivo); $j++){
                            $resp_auto_arch = new RespuestaAutomaticaAdjunto();
                            $resp_auto_arch->nombre=$archivo[$j];
                            $resp_auto_arch->resp_auto_id=$resp_auto->id;
                            $resp_auto_arch->mailing_id=$mailing;
                            $resp_auto_arch->estado='A';
                            $resp_auto_arch->empresa_id=$objinfoUser->empresa_id;
                            $resp_auto_arch->user_id=Auth::user()->id;
                            $resp_auto_arch->fecha_creacion = date('Y-m-d h:i:s');
                            $resp_auto_arch->save();
                            $path= public_path().'/files/'.$resp_auto->id.'/'; 
                               
                                   // $path= public_path().'/files/11/'; 
                                if(!File::exists($path)) { 
                                        File::makeDirectory($path, 0777, true, true);
                                } 
                                rename(public_path().'/files/'.$archivo[$j], $path.$archivo[$j]); 
                        }
                        for($j=0; $j<count($programa_adj); $j++){
                            $resp_auto_arch_prog = new RespuestaAutomaticaAdjuntoPrograma();
                            $resp_auto_arch_prog->resp_auto_adj_id=$resp_auto_arch->id;
                            $resp_auto_arch_prog->resp_auto_adj_nsecu_id=$programa_adj[$j];
                            $resp_auto_arch_prog->save();
                        }
                    }
                     DB::commit();
                    return ['datos'=>'Registro completado ','opcion'=>'ok'];

                }
            }else{
                $respuestaAutomatica = RespuestaAutomatica::where('formulario_id',$form_id)->where('estado','A')->first();
                $op_plantilla_old= $respuestaAutomatica->resp_auto_tipo;
                $resp_auto =  RespuestaAutomatica::find($cod_respuesta);
                $resp_auto->formulario_id = $form_id;
                $resp_auto->nombre = $nombre;
                $resp_auto->asunto = $asunto;
                $resp_auto->resp_auto_tipo = $op_plantilla;
                $resp_auto->user_id = $objinfoUser->id;
                $resp_auto->empresa_id = $objinfoUser->empresa_id;
                $resp_auto->estado = 'A';
                $resp_auto->save();

                if($op_plantilla=="P"){
                       /* $programa2 = $request->programa2;
                        $progP = explode(",",$programa2);
                        $programa = $request->programa;
                        if(count($progP) > count(array_unique($progP))){
                          return ['datos'=>'Varias carreras se encuentra en diferentes plantillas','opcion'=>'no'];
                        }else{*/
                            $prog = explode(",",$programa);
                            $prog0= [];
                            for ($i=0; $i < count($prog) ; $i++) { 
                                $prog0[$i]= explode("_",$prog[$i]);
                            }
                           //var_dump($prog0); exit;
                            for($k=0; $k<count($prog0); $k++){
                                $respuestaAutomatica = RespuestaAutomaticaNsecundario::where('mailing_id',$prog0[$k][1])->where('resp_auto_id',$resp_auto->id)->update(array('estado' => 'I'));
                                $resp_auto_nivel = new RespuestaAutomaticaNsecundario();
                                $resp_auto_nivel->nsecundario_id=$prog0[$k][0];
                                $resp_auto_nivel->mailing_id=$prog0[$k][1];
                                $resp_auto_nivel->resp_auto_id=$resp_auto->id;
                                $resp_auto_nivel->estado='A';
                                $resp_auto_nivel->empresa_id=$objinfoUser->empresa_id;
                                $resp_auto_nivel->user_id=Auth::user()->id;
                                $resp_auto_nivel->fecha_creacion = date('Y-m-d h:i:s');
                               $resp_auto_nivel->save();
                                

                            }
                            if(!empty($archivos)){
                                    for($j=0; $j<count($archivo); $j++){
                                    $resp_auto_arch = new RespuestaAutomaticaAdjunto();
                                    $resp_auto_arch->nombre=$archivo[$j];
                                    $resp_auto_arch->resp_auto_id=$resp_auto->id;
                                    $resp_auto_arch->estado='A';
                                    $resp_auto_arch->empresa_id=$objinfoUser->empresa_id;
                                    $resp_auto_arch->user_id=Auth::user()->id;
                                    $resp_auto_arch->fecha_creacion = date('Y-m-d h:i:s');
                                    $resp_auto_arch->save();
                                    $path= public_path().'/files/'.$resp_auto->id.'/'; 
                                
                                   // $path= public_path().'/files/11/'; 
                                if(!File::exists($path)) { 
                                        File::makeDirectory($path, 0777, true, true);
                                } 
                                rename(public_path().'/files/'.$archivo[$j], $path.$archivo[$j]); 
                                    $resp_auto_arch_prog = new RespuestaAutomaticaAdjuntoPrograma();
                                    $resp_auto_arch_prog->resp_auto_adj_id=$resp_auto_arch->id;
                                    $resp_auto_arch_prog->resp_auto_adj_nsecu_id=$programa_adj[$j];
                                    $resp_auto_arch_prog->save();

                                    }
                                }

                            DB::commit();
                            return ['datos'=>'Registro completado ','opcion'=>'ok'];
                       // }
                }else{
                        $mailing = $request->mailing;
                        $resp_auto_nivel = new RespuestaAutomaticaNsecundario();
                        $resp_auto_nivel->mailing_id=$mailing;
                        $resp_auto_nivel->resp_auto_id=$resp_auto->id;
                        $resp_auto_nivel->estado='A';
                        $resp_auto_nivel->empresa_id=$objinfoUser->empresa_id;
                        $resp_auto_nivel->user_id=Auth::user()->id;
                        $resp_auto_nivel->fecha_creacion = date('Y-m-d h:i:s');
                        $resp_auto_nivel->save();
                        if(!empty($archivos)){
                            for($j=0; $j<count($archivo); $j++){
                                $resp_auto_arch = new RespuestaAutomaticaAdjunto();
                                $resp_auto_arch->nombre=$archivo[$j];
                                $resp_auto_arch->resp_auto_id=$resp_auto->id;
                                $resp_auto_arch->mailing_id=$mailing;
                                $resp_auto_arch->estado='A';
                                $resp_auto_arch->empresa_id=$objinfoUser->empresa_id;
                                $resp_auto_arch->user_id=Auth::user()->id;
                                $resp_auto_arch->fecha_creacion = date('Y-m-d h:i:s');
                                $resp_auto_arch->save();
                                $path= public_path().'/files/'.$resp_auto->id.'/'; 
                                //var_dump($path); exit;
                                   // $path= public_path().'/files/11/'; 
                                if(!File::exists($path)) { 
                                        File::makeDirectory($path, 0777, true, true);
                                } 
                                rename(public_path().'/files/'.$archivo[$j], $path.$archivo[$j]); 
                            }
                            for($j=0; $j<count($programa_adj); $j++){
                                $resp_auto_arch_prog = new RespuestaAutomaticaAdjuntoPrograma();
                                $resp_auto_arch_prog->resp_auto_adj_id=$resp_auto_arch->id;
                                $resp_auto_arch_prog->resp_auto_adj_nsecu_id=$programa_adj[$j];
                                $resp_auto_arch_prog->save();
                            }
                        }
                        DB::commit();
                        return ['datos'=>'Registro completado ','opcion'=>'ok'];

                }
              
            }

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
        }

    }

  /*  public function datosGuardado(Request $request){
        $objinfoUser = Session::get('infoUser');
        $form_id= $request->plantilla;
        $nombre= $request->nombre;
        $asunto= $request->asunto;
        $op_plantilla= $request->op_plantilla;
        // var_dump('op_plantilla12: '.$op_plantilla);
        $cod_respuesta= $request->cod_respuesta;
        $respuestaAutomatica = RespuestaAutomatica::where('formulario_id',$form_id)->where('estado','A')->where('id',$cod_respuesta)->count();
        $contAutomatica = RespuestaAutomatica::where('formulario_id',$form_id)->where('estado','A')->where('id','!=',$cod_respuesta)->count();
        $contRespAuto = RespuestaAutomatica::where('formulario_id',$form_id)->where('estado','A')->count();
        if($contRespAuto >0 && $contAutomatica>0){
            return response()->json(array('datos'=>'Este fromulario ya tiene respuesta automática','opcion'=>'no'));
        }

        if($respuestaAutomatica ==0 ){
            $resp_auto = new RespuestaAutomatica();
            $resp_auto->formulario_id = $form_id;
            $resp_auto->nombre = $nombre;
            $resp_auto->asunto = $asunto;
            $resp_auto->resp_auto_tipo = $op_plantilla;
            $resp_auto->user_id = $objinfoUser->id;
            $resp_auto->empresa_id = $objinfoUser->empresa_id;
            $resp_auto->estado = 'A';
            $resp_auto->save();
            $respuestaAutomatica = RespuestaAutomatica::where('formulario_id',$form_id)->where('estado','A')->first();
            $op_plantilla_old= $respuestaAutomatica->resp_auto_tipo;
            if(trim($op_plantilla)=='P'){
                $sql = "SELECT c.nombre as nom_mail,c.id as cod_mail FROM formularios as f
                        left join mailing as c on c.campana_id = f.campana_id
                        WHERE f.estado='A'  and c.estado='A'and f.id=".$form_id." and f.empresa_id=".$objinfoUser->empresa_id;
                $listMailing = DB::select($sql);

                $sql = "SELECT n.nombre as nom_nivel2,n.id as cod_nivel2 FROM formularios as f
                        left join campana_programa as c on c.campana_id = f.campana_id
                        left join nivel_secundario as n on n.id=c.nsecundario_id
                        WHERE f.estado='A'  and f.id=".$form_id." and f.empresa_id=".$objinfoUser->empresa_id;
                $listNivel2 = DB::select($sql);
                $datos =array($listMailing,$listNivel2);
                $vista= view('rautomatica.tblTab2',['listMailing'=>$listMailing,'listNivel2'=>$listNivel2,'form_id'=> $form_id,'op_plantilla'=>$op_plantilla,'tab'=>'list_mail'])->render(); 
                $vista_archivo= view('rautomatica.tblPrograma',['listNivel2'=>$listNivel2])->render(); 

            }else{
            
                $sql = "SELECT  a.nombre, a.id  from mailing as a  
                        left join campana as b on a.campana_id= b.id
                        left join campana_programa as c on b.id= c.campana_id
                        where a.campana_id IS NULL OR  a.estado != 'X' and c.nsecundario_id=0";
                $mailing = DB::select($sql);
                $vista= view('rautomatica.tblTab2',['mailing'=>$mailing,'op_plantilla'=>$op_plantilla,'tab'=>'list_mail'])->render(); 
                $vista_archivo="";

            }

            
            return response()->json(array('html'=>$vista,'html_programa'=>$vista_archivo,'datos'=>'Los datos se guardaron con exito','opcion'=>'ok','cod_resp'=>$resp_auto->id,'op_plantilla'=>$op_plantilla_old));
        }else{
            $respuestaAutomatica = RespuestaAutomatica::where('formulario_id',$form_id)->where('estado','A')->first();
            $op_plantilla_old= $respuestaAutomatica->resp_auto_tipo;
            $resp_auto =  RespuestaAutomatica::find($cod_respuesta);
            $resp_auto->formulario_id = $form_id;
            $resp_auto->nombre = $nombre;
            $resp_auto->asunto = $asunto;
            $resp_auto->resp_auto_tipo = $op_plantilla;
            $resp_auto->user_id = $objinfoUser->id;
            $resp_auto->empresa_id = $objinfoUser->empresa_id;
            $resp_auto->estado = 'A';
            $resp_auto->save();
            $sql = "SELECT n.nombre as nom_nivel2,n.id as cod_nivel2 FROM formularios as f
                        left join campana_programa as c on c.campana_id = f.campana_id
                        left join nivel_secundario as n on n.id=c.nsecundario_id
                        WHERE f.estado='A'  and f.id=".$form_id." and f.empresa_id=".$objinfoUser->empresa_id;
                $listNivel2 = DB::select($sql);

            if(trim($op_plantilla)=='P'){
                $sql = "SELECT c.nombre as nom_mail,c.id as cod_mail FROM formularios as f
                        left join mailing as c on c.campana_id = f.campana_id
                        WHERE f.estado='A'  and c.estado='A'and f.id=".$form_id." and f.empresa_id=".$objinfoUser->empresa_id;
                $listMailing = DB::select($sql);

                
                $datos =array($listMailing,$listNivel2);
                $vista= view('rautomatica.tblTab2',['listMailing'=>$listMailing,'listNivel2'=>$listNivel2,'form_id'=> $form_id,'op_plantilla'=>$op_plantilla,'tab'=>'list_mail'])->render();
                $vista_archivo= view('rautomatica.tblPrograma',['listNivel2'=>$listNivel2])->render();
               

            }else{
            
                $sql = "SELECT  a.nombre, a.id  from mailing as a  
                        left join campana as b on a.campana_id= b.id
                        left join campana_programa as c on b.id= c.campana_id
                        where a.campana_id IS NULL OR  a.estado != 'X' and c.nsecundario_id=0";
                $mailing = DB::select($sql);
                $vista= view('rautomatica.tblTab2',['mailing'=>$mailing,'op_plantilla'=>$op_plantilla,'tab'=>'list_mail'])->render(); 
                  $vista_archivo='';

            }
             // var_dump('op_plantilla'.$op_plantilla); exit; 
            
            return response()->json(array('html'=>$vista,'html_programa'=>$vista_archivo,'datos'=>'Los datos se guardaron con exito','opcion'=>'ok','cod_resp'=>$resp_auto->id,'op_plantilla'=>$op_plantilla_old));
          
        }
    }
*/
    public function datosSeleccionFormulario(Request $request){
        $objinfoUser = Session::get('infoUser');
        $form_id= $request->form_id;
        $op_plantilla= $request->op_plantilla;

        if(trim($op_plantilla)=='P'){
            $sql = "SELECT c.nombre as nom_mail,c.id as cod_mail FROM formularios as f
                    left join mailing as c on c.campana_id = f.campana_id
                    WHERE f.estado='A'  and c.estado='A'and f.id=".$form_id." and f.empresa_id=".$objinfoUser->empresa_id;
            $listMailing = DB::select($sql);

            $sql = "SELECT n.nombre as nom_nivel2,n.id as cod_nivel2 FROM formularios as f
                    left join campana_programa as c on c.campana_id = f.campana_id
                    left join nivel_secundario as n on n.id=c.nsecundario_id
                    WHERE f.estado='A'  and f.id=".$form_id." and f.empresa_id=".$objinfoUser->empresa_id;
            $listNivel2 = DB::select($sql);
            $datos =array($listMailing,$listNivel2);
            return view('rautomatica.tblTab2',['listMailing'=>$listMailing,'listNivel2'=>$listNivel2,'form_id'=> $form_id,'op_plantilla'=>$op_plantilla]);
        }else{
            
            $sql = "SELECT  a.nombre, a.id  from mailing as a  
                    left join campana as b on a.campana_id= b.id
                    left join campana_programa as c on b.id= c.campana_id
                    where a.campana_id IS NULL OR  a.estado != 'I' and c.nsecundario_id=0";
            $mailing = DB::select($sql);
            return view('rautomatica.tblTab2',['mailing'=>$mailing,'op_plantilla'=>$op_plantilla]);

        }


    }

    public function guardarNsecundario(Request $request){
        $objinfoUser = Session::get('infoUser');
        $form_id= $request->formulario;
        //$nivel2= $request->nivel2;
        $mailing= $request->mailing;
        $nombre= $request->nombre;
        $asunto= $request->asunto;
        $op_plantilla= $request->op_plantilla;
       // var_dump($request->nivel2); exit;
        $nivel2= explode(',',$request->nivel2);
        
        $respuestaAutomatica = RespuestaAutomatica::where('formulario_id',$form_id)->where('estado','A')->count();
        if($respuestaAutomatica ==0){
            $resp_auto = new RespuestaAutomatica();
            $resp_auto->formulario_id = $form_id;
            $resp_auto->nombre = $nombre;
            $resp_auto->asunto = $asunto;
            $resp_auto->resp_auto_tipo = $op_plantilla;
            //$resp_auto->fecha_creacion = $form_id;
            $resp_auto->user_id = $objinfoUser->id;
            $resp_auto->empresa_id = $objinfoUser->empresa_id;
            $resp_auto->estado = 'A';
            $resp_auto->save();
        }
         $respuestaAutomatica = RespuestaAutomatica::where('formulario_id',$form_id)->where('estado','A')->get();
         foreach ($respuestaAutomatica as $key ) {
             $codigo = $key->id;
         }
        $eliminacion_nivel2=RespuestaAutomaticaNsecundario::where('resp_auto_id',$codigo)->delete();
        if($op_plantilla=='P'){
            for($a=0; $a< count($nivel2); $a++){
                       $nivel2_formulario = new RespuestaAutomaticaNsecundario();
                       $nivel2_formulario->nsecundario_id= $nivel2[$a];
                       $nivel2_formulario->mailing_id=$mailing;
                       $nivel2_formulario->resp_auto_id= $codigo;
                       $nivel2_formulario->empresa_id=$objinfoUser->empresa_id;
                       $nivel2_formulario->estado='A';
                       $nivel2_formulario->save();

                   
            }
        }
         

    }

    public function eliminarRespAutomatica(Request $request){
        try {
            $resp_auto  = RespuestaAutomatica::find($request->cod_campana);
            $resp_auto->estado='I';
            $resp_auto->save();
            return ['msg' => 'success', 'data' => 'Se ha desactivado correctamente: ' . $resp_auto->nombre];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }
    
    public function subirArchivos(Request $request){
       // var_dump($request->op_plantilla); exit;
            if($request->op_plantilla=='P'){
                $mensaje = ['archivo_tarea.required' => 'Subir un archivo',
                    'niv_arch.required' => 'Seleccionar un programa'
                    ]; 
                $validacion = Validator::make($request->all(), ['archivo_tarea'=> 'required','niv_arch'=> 'required'], $mensaje);
            }else{
                $mensaje = ['archivo_tarea.required' => 'Subir un archivo',
                    
                    ];
                $validacion = Validator::make($request->all(), ['archivo_tarea'=> 'required'], $mensaje);
            }
        
        
        if($validacion->fails()){
            $error=$validacion->errors();
           // var_dump($error); exit;
           return array('mensaje'=>$error,'clase'=>'error','opcion'=>'no');
        }
        $op_plantilla = $request->op_plantilla;
        $cod_respuesta = $request->cod_respuesta;
        $niv_arch = $request->niv_arch;
        $path= public_path().'/files/'; 
       // $path= public_path().'/files/11/'; 
        if(!File::exists($path)) { 
            File::makeDirectory($path, 0777, true, true);
        } 
        $nsecundario= NivelSecundario::find($niv_arch);
        $max_size =(int)ini_get('upload_max_filesize') *10240;
        $file=$request->file('archivo_tarea');
       
        if($request->hasFile('archivo_tarea')){
            //$file_name= $request->file('archivo_tarea').'_'.date('Y-m-d-H:i:s').'.'.$file->getClientOriginalExtension();
            $file_name=pathinfo($request->file('archivo_tarea')->getClientOriginalName(), PATHINFO_FILENAME).'_'.date('YmdHis'); 
            $file_name=$file_name.'.'.$file->getClientOriginalExtension();
            $file->move($path,$file_name);
            return ['mensaje'=>'Se subio correctamente los datos','archivo'=>$file_name,'cod_respuesta'=>$cod_respuesta,'niv_arch'=>$niv_arch,'opcion'=>'ok','nsecundario'=>$nsecundario];
        }else{
            return ['mensaje'=>'Seleccionar un archivo','opcion'=>'no'];
        } 
    } 

    public function eliminarArchivo(Request $request){
        $nombre = $request->nombre;
        $resp_auto = $request->resp_auto;
        $path= public_path().'/files/'.$resp_auto.'/'.$nombre; 
       // $path= public_path().'/files/11/'.$nombre; 
        if(File::exists($path)) { 
            File::delete($path);
          // var_dump('eliminar'); exit;
        }
    }

    public function datosEnviados(Request $request){
        //var_dump($request->programa2); var_dump($request->programa3); var_dump($request->programa); exit;
       
        $objinfoUser = Session::get('infoUser');
        $archivos = $request->archivo;
        $programas = $request->programa_arc;
        
        $plantilla = $request->plantilla;
        $cod_respuesta = $request->cod_respuesta;
        $op_plantilla   = $request->op_plantilla;
        $respAutoNS = RespuestaAutomaticaNsecundario::where('resp_auto_id',$cod_respuesta)->get();
        //var_dump($respAutoNS); exit;
        if(!empty($respAutoNS)){
            $respAutoNS = DB::table('respuesta_automatica_nsecundario')->where('resp_auto_id',$cod_respuesta)->delete();
         
        }
        
      
        $respAutoAdj = RespuestaAutomaticaAdjunto::where('resp_auto_id',$cod_respuesta)->get();

        if(!empty($respAutoAdj)){
            foreach ($respAutoAdj as $value) {
                 $respAutoAdj = DB::table('respuesta_automatica_adjunto_nsecundario')->where('resp_auto_adj_id',$value->id)->delete();
            }
             $respAutoAdj = DB::table('respuesta_automatica_adjunto')->where('resp_auto_id',$cod_respuesta)->delete();
        }

        $archivo = explode(",",$archivos);
        $programa_adj = explode(",",$programas);
        
        if($op_plantilla=="P"){
            $programa2 = $request->programa2;
            $progP = explode(",",$programa2);
            $programa = $request->programa;
            if(count($progP) > count(array_unique($progP))){
              return ['datos'=>'Varias carreras se encuentra en diferentes plantillas','opcion'=>'no'];
            }else{
                $prog = explode(",",$programa);
                $prog0= [];
                for ($i=0; $i < count($prog) ; $i++) { 
                    $prog0[$i]= explode("_",$prog[$i]);
                }
               //var_dump($prog0); exit;
                for($k=0; $k<count($prog0); $k++){
                    $resp_auto_nivel = new RespuestaAutomaticaNsecundario();
                    $resp_auto_nivel->nsecundario_id=$prog0[$k][0];
                    $resp_auto_nivel->mailing_id=$prog0[$k][1];
                    $resp_auto_nivel->resp_auto_id=$cod_respuesta;
                    $resp_auto_nivel->estado='A';
                    $resp_auto_nivel->empresa_id=$objinfoUser->empresa_id;
                    $resp_auto_nivel->user_id=Auth::user()->id;
                    $resp_auto_nivel->fecha_creacion = date('Y-m-d h:i:s');
                   $resp_auto_nivel->save();
                    

                }
                //var_dump($archivos); exit;
                if(!empty($archivos)){
                        for($j=0; $j<count($archivo); $j++){
                        $resp_auto_arch = new RespuestaAutomaticaAdjunto();
                        $resp_auto_arch->nombre=$archivo[$j];
                        $resp_auto_arch->resp_auto_id=$cod_respuesta;
                       // $resp_auto_arch->mailing_id=$prog0[$k][1];
                        $resp_auto_arch->estado='A';
                        $resp_auto_arch->empresa_id=$objinfoUser->empresa_id;
                        $resp_auto_arch->user_id=Auth::user()->id;
                        $resp_auto_arch->fecha_creacion = date('Y-m-d h:i:s');
                        $resp_auto_arch->save();
                        $resp_auto_arch_prog = new RespuestaAutomaticaAdjuntoPrograma();
                        $resp_auto_arch_prog->resp_auto_adj_id=$resp_auto_arch->id;
                        $resp_auto_arch_prog->resp_auto_adj_nsecu_id=$programa_adj[$j];
                        $resp_auto_arch_prog->save();

                        }
                      /*  for($j=0; $j<count($programa_adj); $j++){
                        $resp_auto_arch_prog = new RespuestaAutomaticaAdjuntoPrograma();
                        $resp_auto_arch_prog->resp_auto_adj_id=$resp_auto_arch->id;
                        $resp_auto_arch_prog->resp_auto_adj_nsecu_id=$programa_adj[$j];
                        $resp_auto_arch_prog->save();
                        }*/
                    }

               
                return ['datos'=>'Registro completado ','opcion'=>'ok'];
            }
        }else{
            $mailing = $request->mailing;
            $resp_auto_nivel = new RespuestaAutomaticaNsecundario();
            $resp_auto_nivel->mailing_id=$mailing;
            $resp_auto_nivel->resp_auto_id=$cod_respuesta;
            $resp_auto_nivel->estado='A';
            $resp_auto_nivel->empresa_id=$objinfoUser->empresa_id;
            $resp_auto_nivel->user_id=Auth::user()->id;
            $resp_auto_nivel->fecha_creacion = date('Y-m-d h:i:s');
            $resp_auto_nivel->save();
            //var_dump($archivos); exit;
            if(!empty($archivos)){
                for($j=0; $j<count($archivo); $j++){
                    $resp_auto_arch = new RespuestaAutomaticaAdjunto();
                    $resp_auto_arch->nombre=$archivo[$j];
                    $resp_auto_arch->resp_auto_id=$cod_respuesta;
                    $resp_auto_arch->mailing_id=$mailing;
                    $resp_auto_arch->estado='A';
                    $resp_auto_arch->empresa_id=$objinfoUser->empresa_id;
                    $resp_auto_arch->user_id=Auth::user()->id;
                    $resp_auto_arch->fecha_creacion = date('Y-m-d h:i:s');
                    $resp_auto_arch->save();
                }
                for($j=0; $j<count($programa_adj); $j++){
                    $resp_auto_arch_prog = new RespuestaAutomaticaAdjuntoPrograma();
                    $resp_auto_arch_prog->resp_auto_adj_id=$resp_auto_arch->id;
                    $resp_auto_arch_prog->resp_auto_adj_nsecu_id=$programa_adj[$j];
                    $resp_auto_arch_prog->save();
                }
            }
            return ['datos'=>'Registro completado ','opcion'=>'ok'];

        }
     
      

     } 

    public function listaRespuesta(){
        $objinfoUser = Session::get('infoUser');
        $sql="select ra.nombre, ra.id, f.nombre as nom_formulario from respuesta_automatica as ra
            left join formularios as f on ra.formulario_id=f.id
            where ra.estado='A' and ra.empresa_id=".$objinfoUser->empresa_id;
            $listaRespAuto = DB::select($sql);
       // $listaRespAuto = RespuestaAutomatica::where('estado', 'A')->where('empresa_id', $objinfoUser->empresa_id)->get();
        return view('rautomatica.tblListaRespuestaAutomatica',['listaRespAuto'=>$listaRespAuto]);

    } 

    public function editarInfFormulario(Request $request){
        $objinfoUser = Session::get('infoUser');
        $cod_resp_auto = $request->id;
        $respAuto = RespuestaAutomatica::where('estado','A')->where('empresa_id',$objinfoUser->empresa_id)->where('id',$cod_resp_auto)->first();
        $respAutoProg = RespuestaAutomaticaNsecundario::where('estado','A')->where('empresa_id',$objinfoUser->empresa_id)->where('resp_auto_id',$cod_resp_auto)->get();
       
        $respAutoArch = DB::table('respuesta_automatica_adjunto')
                     ->select(DB::raw('nombre, id'))
                     ->where('estado','A')->where('empresa_id',$objinfoUser->empresa_id)->where('resp_auto_id',$cod_resp_auto)
                     ->groupBy('nombre','id')
                     ->get();

        $respAutoArchNivel2 = DB::table('respuesta_automatica_adjunto_nsecundario')
                     
                     ->leftJoin('respuesta_automatica_adjunto','respuesta_automatica_adjunto_nsecundario.resp_auto_adj_id','=','respuesta_automatica_adjunto.id')
                     ->leftJoin('nivel_secundario','respuesta_automatica_adjunto_nsecundario.resp_auto_adj_nsecu_id','=','nivel_secundario.id')
                     ->where('respuesta_automatica_adjunto.estado','A')->where('respuesta_automatica_adjunto.empresa_id',$objinfoUser->empresa_id)->where('respuesta_automatica_adjunto.resp_auto_id',$cod_resp_auto)
                     ->select(DB::raw('respuesta_automatica_adjunto_nsecundario.resp_auto_adj_nsecu_id,respuesta_automatica_adjunto_nsecundario.resp_auto_adj_id ,respuesta_automatica_adjunto.nombre,nivel_secundario.nombre as nombre_programa'))
                     ->groupBy('respuesta_automatica_adjunto_nsecundario.resp_auto_adj_nsecu_id','respuesta_automatica_adjunto_nsecundario.resp_auto_adj_id','respuesta_automatica_adjunto.nombre','nivel_secundario.nombre')
                     ->get();

        if($respAuto->resp_auto_tipo=='P'){
        $sql = "SELECT c.nombre as nom_mail,c.id as cod_mail FROM formularios as f
                        left join mailing as c on c.campana_id = f.campana_id
                        WHERE f.estado='A'  and c.estado='A'and f.id=".$respAuto->formulario_id." and f.empresa_id=".$objinfoUser->empresa_id;
                $listMailing = DB::select($sql);

                $sql = "SELECT n.nombre as nom_nivel2,n.id as cod_nivel2 FROM formularios as f
                        left join campana_programa as c on c.campana_id = f.campana_id
                        left join nivel_secundario as n on n.id=c.nsecundario_id
                        WHERE f.estado='A'  and f.id=".$respAuto->formulario_id." and f.empresa_id=".$objinfoUser->empresa_id;
                $listNivel2 = DB::select($sql);
                $vista_archivo= view('rautomatica.tblPrograma',['listNivel2'=>$listNivel2])->render(); 
             //   $vista_archivo="";
                $vista="";
         }else{
            $sql = "SELECT  a.nombre, a.id  from mailing as a  
                        left join campana as b on a.campana_id= b.id
                        left join campana_programa as c on b.id= c.campana_id
                        where a.campana_id IS NULL OR  a.estado != 'I' and c.nsecundario_id=0";
                $listMailing = DB::select($sql);
                $mailing = $listMailing;
                $vista= view('rautomatica.tblTab2',['mailing'=>$mailing,'op_plantilla'=>'G','tab'=>'list_mail'])->render(); 
                $vista_archivo="";
          //  $listMailing="";
            $listNivel2="";
         }  

    return ['html'=>$vista,'html_programa'=>$vista_archivo,'respAuto'=>$respAuto,'respAutoProg'=>$respAutoProg,'respAutoArch'=>$respAutoArch,'listMailing'=>$listMailing,'listNivel2'=>$listNivel2,'respAutoArchNivel2'=>$respAutoArchNivel2];
    }   
}
    
