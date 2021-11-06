<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = "sede";
    public $timestamps = false;
    protected $primaryKey = 'id';



    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    public function metas()
    {
        return $this->belongsTo('App\Metas');
    }
}
