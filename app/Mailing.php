<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    protected $table = "mailing";
    public $timestamps = false;
    protected $primaryKey = 'id';
     public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
    public function campana()
    {
        return $this->belongsTo(Campana::class);
    }

}
