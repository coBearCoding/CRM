<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    protected $table = 'postulante';

    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
    public $timestamps = false;

    //uno a uno
    public function solicitud()
    {
    	return $this->hasOne(Solicitud::class,'postulante_id','id');
    }

    //uno a uno
    public function datos_familiares()
    {
        return $this->hasOne(PostulanteFamiliares::class,'postulante_id','id');
    }

    //uno a uno
    public function datos_estudiantiles()
    {
        return $this->hasOne(PostulanteEstudiantiles::class,'postulante_id','id');
    }

    //uno a uno
    public function datos_carrera()
    {
        return $this->hasOne(PostulanteCarrera::class,'postulante_id','id');
    }

    //uno a uno
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
