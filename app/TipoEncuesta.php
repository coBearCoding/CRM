<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEncuesta extends Model
{
    protected $table = "tipo_encuesta";
    protected $primaryKey = "id";
    public $timestamps = false;

   
    
    public function pregunta()
    {
        return $this->belongsTo('App\PreguntasEncuesta','id','tipo_encuesta_id');
    }
}
