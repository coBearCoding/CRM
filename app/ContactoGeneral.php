<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ContactoGeneral extends Model
{
    protected $table = "contacto_general";
    protected $primaryKey = "id";
    public $timestamps = false;
    
    protected $fillable = ['email','nombres','apellidos','estado_correo','id'];

    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

}

