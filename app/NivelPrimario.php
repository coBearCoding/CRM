<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NivelPrimario extends Model
{

    protected $table = "nivel_primario";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $dateFormat = 'Y-m-d H:i:s+';


    public function nivelsecundario()
    {
        return $this->belongsTo('App\NivelSecundario');
    }
}
