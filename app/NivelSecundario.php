<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NivelSecundario extends Model
{

    protected $table = "nivel_secundario";
    public $timestamps = false;
    protected $primaryKey = 'id';
    

    public function nivelprimario()
    {
        return $this->hasOne('App\NivelPrimario','id','nprimario_id');
    }
}
