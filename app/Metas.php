<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metas extends Model
{
     protected $table = "metas";
    //public $timestamps = false;
    protected $primaryKey = 'id';
     public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

    public $timestamps  = false;

    public function sede()
    {
        return $this->hasOne('App\Sede','id','sede_id');
    }
}
