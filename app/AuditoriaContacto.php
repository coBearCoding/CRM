<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditoriaContacto extends Model
{
     public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

    public $timestamps  = false;

    //protected $dateFormat = 'Y-m-d H:i:s+';

    public function creado_por()
    {
    	return $this->belongsTo(User::class,'created_by');
    }

    public function accion()
    {
    	return $this->belongsTo(Acciones::class);
    }

    public static function auditoria($contacto_tipo_id,$accion_id,$observacion){

        $fecha= date('Y').'-'.date('m').'-'.date('d').' '.date('H:i:s.v');
        $auditoria = new AuditoriaContacto;
        $auditoria->contacto_tipo_id = $contacto_tipo_id;
        $auditoria->accion_id = $accion_id;
        $auditoria->observacion = $observacion;
        $auditoria->created_by = (!empty(Auth::user())) ? Auth::user()->id : 34;
        $auditoria->created_at = $fecha;
        $auditoria->updated_at = $fecha;
        $auditoria->save();
        return $auditoria;
    }
}
