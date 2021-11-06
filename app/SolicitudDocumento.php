<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudDocumento extends Model
{
    //
    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
    public $timestamps = false;

    public function documento()
    {
    	return $this->belongsTo(Documento::class);
    }
}
