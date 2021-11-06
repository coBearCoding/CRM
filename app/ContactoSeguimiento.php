<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactoSeguimiento extends Model
{
    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

    public $timestamps  = false;

    //protected $dateFormat = 'Y-m-d H:i:s+';
    
    public function contacto_tipo()
    {
    	return $this->belongsTo(TipoContacto::class);
    }

    public function estado_comercial()
    {
    	return $this->belongsTo(EstadoComercial::class);
    }

    public function medio_gestion()
    {
    	return $this->belongsTo(MediosGestion::class);
    }

    public function creado_por()
    {
    	return $this->belongsTo(User::class,'created_by');
    }
}
