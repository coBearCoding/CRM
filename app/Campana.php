<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;



class Campana extends Model
{
    protected $table = "campana";
    protected $primaryKey = "id";
    public $timestamps = false;
    
    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }


    //protected $dateFormat = 'Y-m-d H:i:s+';
}

