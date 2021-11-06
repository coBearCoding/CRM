<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermisosNPrimario extends Model
{
    protected $table = "permisos_nprimario";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function vendedor()
    {
    	return $this->belongsTo(User::class,'user_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function nprimario()
    {
        return $this->belongsTo(NivelPrimario::class);
    }
}
