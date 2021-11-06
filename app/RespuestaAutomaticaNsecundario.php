<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespuestaAutomaticaNsecundario extends Model
{
    protected $table = "respuesta_automatica_nsecundario";
    protected $primaryKey = "id";
    public $timestamps = false;

  /*  public function respuestaAutomatica(){
    	return $this->belongsTo(RespuestaAutomatica::class);
    }

    public function mailing(){
    	return $this->belongsTo(Mailing::class);
    }*/
}
