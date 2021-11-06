<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostulanteFamiliares extends Model
{
    //
    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
    public $timestamps = false;
}
