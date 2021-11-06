<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    protected $table = "formularios";
    protected $primaryKey = 'id';
    
     public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

    public $timestamps  = false;

    //protected $dateFormat = 'Y-m-d H:i:s+';

    public function campana()
    {
        return $this->belongsTo(Campana::class);
    }
}
