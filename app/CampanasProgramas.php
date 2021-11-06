<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampanasProgramas extends Model
{
    protected $table = "campana_programa";
    public $timestamps = false;
    protected $primaryKey = 'id';
     public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

    //protected $dateFormat = 'Y-m-d H:i:s+';

    public function programa()
    {
    	return $this->belongsTo(NivelSecundario::class,'nsecundario_id');
    }

    public function campana()
    {
    	return $this->belongsTo(Campana::class);
    } 
}
