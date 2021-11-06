<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tareas extends Model
{
    protected $table = "tarea";

    public $timestamps = false;

    public $primaryKey = 'cod_tarea';

    

    public function usuario(){
    	return $this->belongsTo(User::class,'cod_usuario');
    }
}
