<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{ 
    protected $table = "solicitud";
    public $timestamps = false;
    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
    protected $fillable =[
        'id','postulante_id','cod_solicitud','estado_id','campana_id'
    ];

    //pertence a un postualnte
    public function postulante()
    {
    	return $this->belongsTo(Postulante::class,'postulante_id');
    }
    //pertence a un estado
    public function solicitud_estado()
    {
    	return $this->belongsTo(SolicitudEstado::class,'estado_id');
    }
    //una solicitud tiene muchos historial
    public function solicitud_historial()
    {
        return $this->hasMany(SolicitudHistorial::class, 'solicitud_id');
    }

    /*//uno a unp
    public function datos_adicional()
    {
    	return $this->hasOne(SolicitudDatosAdicional::class, 'solicitud_id');
    }

    //uno a unp
    public function datos_convivencia()
    {
        return $this->hasMany(SolicitudDatosConvivencia::class,'solicitud_id');
    }

    //uno a uno
    public function datos_familia()
    {
        return $this->hasOne(SolicitudDatosFamilia::class,'solicitud_id');
    }

    //uno a uno
    public function datos_laboral()
    {
        return $this->hasOne(SolicitudDatosLaboral::class,'solicitud_id');
    }

    //uno a uno
    public function datos_mensual()
    {
        return $this->hasOne(SolicitudDatosMensual::class,'solicitud_id');
    }*/

    //uno a uno
    public function documentos()
    {
        return $this->hasMany(SolicitudDocumento::class,'solicitud_id');
    }
    
}
