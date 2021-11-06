<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactoHistorico extends Model
{
    /*protected $attributes = [
        'estado_comercial_id' => 11
    ];*/
   // protected $dateFormat = 'Y-m-d H:i:s+';

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

    public function fuente_contacto()
    {
    	return $this->belongsTo(FuentesContacto::class);
    }

    public function campana_programa()
    {
    	return $this->belongsTo(CampanasProgramas::class);
    }

    public function otro_pragrama()
    {
    	return $this->belongsTo(NivelSecundario::class);
    }

    public function estado_comercial()
    {
    	return $this->belongsTo(EstadoComercial::class);
    }
	
	public function vendedor()
    {
    	return $this->belongsTo(User::class);
    }

    public function creado_por()
    {
    	return $this->belongsTo(User::class,'created_by');
    }
    
    public function motivo_desinteres()
    {
    	return $this->belongsTo(MotivoDesintere::class);
    }

    public function nivel_secundario()
    {
    	return $this->belongsTo(NivelSecundario::class,'nsecundario_id');
    }
    
    public function campana()
    {
    	return $this->belongsTo(Campana::class);
    }

    public function seguimiento()
    {
    	return $this->belongsTo(ContactoSeguimiento::class,'contacto_tipo_id','contacto_tipo_id')->where('ultimo_seguimiento','S');
    }
}
