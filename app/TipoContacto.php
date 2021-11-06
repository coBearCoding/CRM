<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoContacto extends Model
{
    protected $table = "tipo_contactos";

    public $timestamps  = false;

    public function contacto(){
    	return $this->belongsTo(Contacto::class)->where('estado','A');
    }

    public function contacto_historico(){
        return $this->hasMany(ContactoHistorico::class,'contacto_tipo_id');
    }

    public function contacto_seguimiento(){
    	return $this->hasMany(ContactoSeguimiento::class,'contacto_tipo_id');
    }

    public function contacto_historico_last(){
    	return $this->hasOne(ContactoHistorico::class,'contacto_tipo_id')->latest();
    }

    public function desinteres(){
    	return $this->hasOne(AuditoriaContacto::class,'contacto_tipo_id')->where('accion_id','6')->where('observacion','like','%No Interesado, Motivo: %')->latest();
    }

    public function auditoria_last(){
    	return $this->hasOne(AuditoriaContacto::class,'contacto_tipo_id')->latest();
    }

    public function autoria_contacto(){
        return $this->hasMany(AuditoriaContacto::class,'contacto_tipo_id')->orderBy('created_at','Desc');
    }

}
