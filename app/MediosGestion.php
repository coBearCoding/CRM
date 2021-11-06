<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediosGestion extends Model
{
    protected $table = "medios_gestion";
    public $timestamps = false;
    protected $primaryKey = 'id';
     public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

}
