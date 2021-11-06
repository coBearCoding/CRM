<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampanasSede extends Model
{
    protected $table = "campana_sede";
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function sede()
    {
    	return $this->belongsTo(Sede::class);
    }

    public function campana()
    {
    	return $this->belongsTo(Campana::class);
    } 
}
