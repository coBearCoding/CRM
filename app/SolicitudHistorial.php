<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudHistorial extends Model
{
    protected $table = "solicitud_historial";
    public $timestamps = false;
    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

    //pertenece a 
    public function SolicitudEstado()
    {
    	return $this->belongsTo(SolicitudEstado::class,'estado_id');
    }

    //pertenece a 
    public function solicitud()
    {
    	return $this->belongsTo(Solicitud::class,'solicitud_id');
    }
}
