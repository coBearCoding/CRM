<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuentesContacto extends Model
{
    protected $table = "fuente_contacto";
    public $timestamps = false;
    protected $primaryKey = 'id';
     public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }


}
