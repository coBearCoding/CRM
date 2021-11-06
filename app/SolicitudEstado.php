<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudEstado extends Model
{
    protected $table = "solicitud_estado";
    public $timestamps = false;
    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
}
