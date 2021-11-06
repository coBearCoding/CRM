<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreguntaEncuesta extends Model
{
    protected $table = "pregunta_encuesta";
    protected $primaryKey = "id";
    public $timestamps = false;
    


    public function tipo()
    {
        return $this->hasOne('App\TipoEncuesta','id','tipo_encuesta_id');
    }

    public function nivel_primario()
    {
        return $this->belongsTo('App\NivelPrimario');
    }

    public function tipo_encuesta()
    {
        return $this->belongsTo('App\TipoEncuesta');
    }
}
