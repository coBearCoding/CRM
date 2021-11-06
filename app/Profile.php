<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = "profiles";
    public $timestamps = false;
    protected $primaryKey = 'id';


    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function empresa()
    {
        return $this->hasOne('App\Empresa','id','empresa_id');
    }

    public function sede()
    {
        return $this->hasOne('App\Sede','id','sede_id');
    }

}
