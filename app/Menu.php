<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = "menu";
    public $timestamps = false;
    protected $primaryKey = 'id';
     public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }


    public function menu()
    {
        return $this->belongsTo('App\Menu','id_princ','id');
    }

    public function menuPadre()
    {
        return $this->hasOne('App\Menu','id','id_princ');
    }





}
