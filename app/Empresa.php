<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{


    protected $table = "empresas";
    public $timestamps = false;
    protected $primaryKey = 'id';
    
     public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }


    //protected $dateFormat = 'Y-m-d H:i:s+';

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }
}
