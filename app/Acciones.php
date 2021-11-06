<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acciones extends Model
{
    //
     public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

    public $timestamps  = false;

    //protected $dateFormat = 'Y-m-d H:i:s+';
}
