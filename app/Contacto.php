<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

    public $timestamps  = false;

    //protected $dateFormat = 'Y-m-d H:i:s+';
    
    public function creado_por()
    {
    	return $this->belongsTo(User::class,'created_by');
    }


    
}
