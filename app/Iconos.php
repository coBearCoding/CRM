<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iconos extends Model
{
    protected $table = "iconos";
    public $timestamps = false;
    protected $primaryKey = 'id';
     public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
}
