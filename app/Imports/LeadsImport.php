<?php

namespace App\Imports;
 
use App\Leads;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Campana;
use App\CampanasProgramas;
use App\Sede;
use App\Profile;
use App\NivelPrimario;
use App\NivelSecundario;
use App\FuentesContacto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Contacto;
use App\TipoContacto;
use App\ContactoHistorico;
use App\AuditoriaContacto; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Events\CrmEvents;

class LeadsImport implements ToCollection,WithHeadingRow
{ 
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct($fte_contacto,$cod_campana,$nivel2,$sede, $cod_vendedor)
    {
        $this->fte_contacto = $fte_contacto;
        $this->cod_campana = $cod_campana;
        $this->nivel2 = $nivel2;
        $this->sede = $sede;
       // $this->cod_vendedor = $cod_vendedor;
       // $this->procedencia = $procedencia;
    }
    public function collection(Collection $leads)
    {   $nuevo=0;
        $actualizar=0;
        $error=0;
        $cont=0;
        
        $fte_contacto=$this->fte_contacto;
        $cod_campana=$this->cod_campana;
        //$procedencia=$this->procedencia; 
        $nivel2=$this->nivel2;
        $programa = CampanasProgramas::find($nivel2);
        $sede=$this->sede;
       // $cod_vendedor=$this->cod_vendedor;
        $campana = Campana::find($cod_campana);
           // $name_campana= $name_campana->nom_campana;
        $objinfoUser = Session::get('infoUser');
        $cod_empresa=$objinfoUser->empresa_id;
//var_dump($leads); exit;
        if(count($leads)>0){
            foreach ($leads as $value) 
            {$cont++;
                
               if(!empty($value['correo']) && !empty($value['nombre'])){

                    try {
                          if($value["generomf"]=='F'){$genero='Femenino';} elseif($value["generomf"]=='M'){$genero='Masculino';}else{$genero='';}
                       //  DB::beginTransaction();
                        $leads = Contacto::where('correo','LIKE', '%'.$value['correo'].'%')->where('estado','A')->first();
                         
                         $asesor = DB::selectOne('SELECT cu.user_id, count(distinct ch.contacto_tipo_id) leads , u.id, u.name, u.email, u.status, p.celular as telefono
                                    FROM campana_users cu
                                           left join contacto_historicos ch on ch.vendedor_id = cu.user_id
                                           join campana c on  c.id = cu.campana_id and c.id = :campana
                                           join users u on u.id = cu.user_id
                                           join profiles p on p.user_id = u.id
                                           left join estado_comercial ec on ec.id= ch.estado_comercial_id and ch.estado_comercial_id in (SELECT id FROM estado_comercial where id not in (2,5,7,8))
                                    where c.estado = :estado and cu.estado=:estado_a
                                    group by cu.user_id,  u.id, u.name, u.email, u.status, p.celular
                                    order by count(distinct ch.contacto_tipo_id)', ['campana' =>  $cod_campana, 'estado' => 'A', 'estado_a' => 'A']);

                        if(empty($leads)){
                            

                            $leads = new Contacto;
                            $leads->nombre=$value["nombre"];
                            $leads->cedula=$value["cedula"];
                            $leads->correo=$value["correo"];
                            $leads->telefono=$value["telefono"];
                            $leads->direccion=$value["direccionciudad"];
                            $leads->genero=$genero;
                            //$leads->procedencia_id=$procedencia;
                            $leads->procedencia=$value["centro_educativo"];
                            $leads->created_by= Auth::user()->id;
                            $leads->estado='A';
                            $leads->save();
                         
                            if (!empty($leads)) {
                                $leads_tipo = TipoContacto::where('contacto_id',$leads->id)->where('tipo_id',1)->first();
                                
                                if (empty($leads_tipo)) {
                                    $leads_tipo = new TipoContacto;
                                    $leads_tipo->contacto_id = $leads->id;
                                    $leads_tipo->tipo_id = 1;
                                    $leads_tipo->save();
                                    
                                }

                                $historico = new ContactoHistorico;
                                $historico->contacto_tipo_id = $leads_tipo->id;
                                $historico->fuente_contacto_id =   $fte_contacto;
                                $historico->campana_programa_id =  $nivel2;
                                $historico->nsecundario_id = $programa->nsecundario_id;
                                $historico->campana_id = $programa->campana_id;
                                $historico->vendedor_id = (!empty($asesor)) ? $asesor->id : null;
                                $historico->created_by= Auth::user()->id;
                                $historico->observacion=$value["observacion"];
                                $historico->estado_comercial_id = 1;
                                $historico->save();
                                AuditoriaContacto::auditoria($leads_tipo->id, 3, "Se asigna asesor $asesor->name");
                                $datos = TipoContacto::with('contacto')->with('contacto_historico_last')->find($leads_tipo->id);
                                event(new CrmEvents($datos)); #se guarda en la tabla notificaciones y se envia en mail al asesor
                                
                            }
                            $fuente_contacto = FuentesContacto::find( $fte_contacto);
                            
                            $nuevo++;
                            $auditoria=AuditoriaContacto::auditoria($leads_tipo->id,1,'Se crea Leads mediante la fuente de contacto '.$fuente_contacto->nombre.' del formulario '.$campana->nombre);
                            
                        }else{
                            $leads_tipo = TipoContacto::where('contacto_id',$leads->id)->where('tipo_id',1)->first();
                                if (empty($leads_tipo)) {
                                    $leads_tipo = new TipoContacto;
                                    $leads_tipo->contacto_id = $leads->id;
                                    $leads_tipo->tipo_id = 1;
                                    $leads_tipo->save();
                                    
                                }
                            $historico = new ContactoHistorico;
                            $historico->contacto_tipo_id = $leads_tipo->id;
                            $historico->fuente_contacto_id =   $fte_contacto;
                            $historico->campana_programa_id =  $nivel2;
                            $historico->nsecundario_id = $programa->nsecundario_id;
                            $historico->campana_id = $programa->campana_id;
                            if(empty($asesor_id)){
                                $historico->vendedor_id = (!empty($asesor)) ? $asesor->id : null;
                            }else{
                                $historico->vendedor_id = $asesor_id ;
                            }
                            $historico->created_by= Auth::user()->id;
                            $historico->estado_comercial_id = 1;

                            $historico->save();
                            AuditoriaContacto::auditoria($leads_tipo->id, 3, "Se asigna asesor $asesor->name");
                            $datos = TipoContacto::with('contacto')->with('contacto_historico_last')->find($leads_tipo->id);
                            event(new CrmEvents($datos)); #se guarda en la tabla notificaciones y se envia en mail al vendedor
                            
                            $fuente_contacto = FuentesContacto::find( $fte_contacto);
                                 
                            $actualizar++;
                            $auditoria=AuditoriaContacto::auditoria($leads_tipo->id,2,'Se modifica Leads mediante la fuente de contacto '.$fuente_contacto->nombre.' del formulario '.$campana->nombre);
                          

                        } 
                                
                        //DB::commit();
                    } catch (Exception $e) {
                       
                    //DB::rollBack();
                    $error++;
                    }      
                        

               }else{
                   $error++;
                }
            }
        
            $msg= 'Nuevo Leads: '.$nuevo.' Leads Modificados: '.$actualizar.'Leads con error: '.$error;
            
          echo $msg; 
        }else{
            $msg='No contiene datos';
            echo $msg; 
        }
        
    }
}
