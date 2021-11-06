<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostulanteEstudiantiles extends Model
{
    //
    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
    public $timestamps = false;
}
