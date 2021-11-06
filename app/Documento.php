<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    public function servicio()
    {
    	return $this->belongsTo(NivelPrimario::class);
    }

    public function tipo_documento()
    {
    	return $this->belongsTo(TipoDocumento::class);
    }
}
