<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoComercial extends Model
{
    protected $table ="estado_comercial";
     public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

    public $timestamps  = false;
}
