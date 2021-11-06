<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampanasUsers extends Model
{
    protected $table = "campana_users";
    public $timestamps = false;
    protected $primaryKey = 'id';
    
    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

    //protected $dateFormat = 'Y-m-d H:i:s+';

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}