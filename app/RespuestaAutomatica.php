<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespuestaAutomatica extends Model
{
    protected $table = "respuesta_automatica";
    protected $primaryKey = "id";
    public $timestamps = false;
   
}
