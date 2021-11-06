<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTrans extends Model
{
    protected $table = "email_trans";

    public $timestamps = false;

    public $primaryKey = 'cod_email_trans';

     public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

    public $timestamps  = false;

    //protected $dateFormat = 'Y-m-d H:i:s+';
}
