<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    public function servicio()
    {
    	return $this->belongsTo(Servicio::class);
    }

    public function dia()
    {
    	return $this->belongsTo(Dia::class);
    }
}
