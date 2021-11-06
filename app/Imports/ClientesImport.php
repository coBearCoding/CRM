<?php

namespace App\Imports;

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

class ClientesImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */

     public function __construct($cod_campana,$nivel2,$sede, $cod_vendedor)
    {
       
        $this->cod_campana = $cod_campana;
       // $this->nivel1 = $nivel1;
        $this->nivel2 = $nivel2;
        $this->sede = $sede;
        $this->cod_vendedor = $cod_vendedor;
        //$this->procedencia = $procedencia;
    }
    public function collection(Collection $clientes)
    {   $nuevo=0;
        $actualizar=0;
        $error=0;
        $cont=0;
        
        $cod_campana=$this->cod_campana;
        $nivel2=$this->nivel2;
        $programa = CampanasProgramas::find($nivel2);
       // $procedencia=$this->procedencia; 
        $sede=$this->sede;
        $cod_vendedor=$this->cod_vendedor;
        $campana = Campana::find($cod_campana);
           // $name_campana= $name_campana->nom_campana;
        $objinfoUser = Session::get('infoUser');
        $cod_empresa=$objinfoUser->empresa_id;

        if(count($clientes)>0){
            foreach ($clientes as $value) 
            {$cont++;
               // var_dump($value); 
               if(!empty($value['correo']) && !empty($value['nombre'])){

                    try {
                        if($value["generomf"]=='F'){$genero='Femenino';} elseif($value["generomf"]=='M'){$genero='Masculino';}else{$genero='';}
                        DB::beginTransaction();
                        $clientes = Contacto::where('correo','LIKE', '%'.$value['correo'].'%')->where('estado','A')->first();
                                                     
                        if(empty($clientes)){
                            $clientes = new Contacto;
                            $clientes->nombre=$value["nombre"];
                            $clientes->cedula=$value["cedula"];
                            $clientes->correo=$value["correo"];
                            $clientes->telefono=$value["telefono"];
                            $clientes->direccion=$value["direccionciudad"];
                            $clientes->genero=$genero;
                            $clientes->nombre_colegio=$value["centro_educativo"];
                           // $clientes->procedencia_id=$procedencia;
                            $clientes->created_by= Auth::user()->id;
                            $clientes->estado='A';
                            $clientes->save();
                         
                            if (!empty($clientes)) {
                                $clientes_tipo = TipoContacto::where('contacto_id',$clientes->id)->where('tipo_id',2)->first();
                                
                                if (empty($clientes_tipo)) {
                                    $clientes_tipo = new TipoContacto;
                                    $clientes_tipo->contacto_id = $clientes->id;
                                    $clientes_tipo->tipo_id = 2;
                                    $clientes_tipo->save();
                                    
                                }

                                $historico = new ContactoHistorico;
                                $historico->contacto_tipo_id = $clientes_tipo->id;
                                
                                $historico->campana_programa_id =  $nivel2;
                                $historico->nsecundario_id = $programa->nsecundario_id;
                                $historico->campana_id = $programa->campana_id;
                                $historico->vendedor_id =  $cod_vendedor;
                                $historico->created_by= Auth::user()->id;
                                $historico->observacion=$value["observacion"];
                                $historico->estado_comercial_id = 1;
                                $historico->save();
                                
                            }
                            //$fuente_contacto = FuentesContacto::find( $fte_contacto);
                            
                            $nuevo++;
                            $auditoria=AuditoriaContacto::auditoria($clientes_tipo->id,2,'Se crea clientes mediante el formulario '.$campana->nombre);
                            //var_dump('11--'.$auditoria); 
                        }else{
                            
                            $clientes_tipo = TipoContacto::where('contacto_id',$clientes->id)->where('tipo_id',2)->first();
                            if (empty($clientes_tipo)) {
                                    $clientes_tipo = new TipoContacto;
                                    $clientes_tipo->contacto_id = $clientes->id;
                                    $clientes_tipo->tipo_id = 2;
                                    $clientes_tipo->save();
                                    
                                }
                            $historico = new ContactoHistorico;
                            $historico->contacto_tipo_id = $clientes_tipo->id;
                            
                            $historico->campana_programa_id =  $nivel2;
                            $historico->nsecundario_id = $programa->nsecundario_id;
                            $historico->campana_id = $programa->campana_id;
                            $historico->vendedor_id =  $cod_vendedor;
                            $historico->created_by= Auth::user()->id;
                            $historico->estado_comercial_id = 1;

                            $historico->save();
                            //var_dump('9--'.$historico);
                           // $fuente_contacto = FuentesContacto::find( $fte_contacto);
                            // var_dump('10--'.$fuente_contacto);       
                            $actualizar++;
                            $auditoria=AuditoriaContacto::auditoria($clientes_tipo->id,2,'Se modifica clientes mediante el formulario '.$campana->nombre);
                            
 
                        } 
                                
                        DB::commit();
                    } catch (Exception $e) {
                       
                    DB::rollBack();
                    $error++;
                    }      
                        

               }else{
                   $error++;
                }
            }
          //  var_dump($cont); exit;
            $msg= '<li>Nuevo Clientes: '.$nuevo.' </li><li>Clientes Modificados: '.$actualizar.'</li><li>Clientes con error: '.$error.'</li>';
            
            echo $msg; 
        }else{
            $msg='No contiene datos';
            echo $msg; 
        }
        
    }
}
