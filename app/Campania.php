<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Campania extends Model
{	
	protected $table = 'campana';
    
    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

    public $timestamps  = false;

    //protected $dateFormat = 'Y-m-d H:i:s+';

    public static function listCampania($filtro){
        $respuesta = DB::connection('sqlsrv')->select(' exec sp_lista_campania ?',array($filtro));
        return $respuesta; 
    }

    public static function cmbSede(){
    	$respuesta = DB::connection('sqlsrv')->select(' exec sp_cmb_sede',array());
        return $respuesta;
	}

    public static function cmbNivel1(){
        $respuesta = DB::connection('sqlsrv')->select(' exec sp_cmb_Programa',array());
        return $respuesta; 
    }

    public static function cmbNivel2($codNivel1){
    	$respuesta = DB::connection('sqlsrv')->select(' exec sp_cmb_oferta ?',array($codNivel1));
        return $respuesta; 
    }

    public static function nuevaCampana($cod_periodo,
                                                $nom_campana,
                                                $fch_inicio,
                                                $fch_fin,
                                                $nom_contacto,
                                                $email_contacto,
                                                $sede,
                                                $nivel1,
                                                $nivel2,
                                                $detalle,
                                                $estadoCampana,
                                                $meta =0){
    	$respuesta = DB::connection('sqlsrv')->insert(' exec sp_nuevo_campania ?,?,?,?,?,?,?,?,?,?,?,?',array($cod_periodo,
                                                $nom_campana,
                                                $fch_inicio,
                                                $fch_fin,
                                                $nom_contacto,
                                                $email_contacto,
                                                $sede,
                                                $nivel1,
                                                $nivel2,
                                                $detalle,
                                                $estadoCampana,
                                                $meta));
        return $respuesta; 
    }

    public function infCampana($cod_campana){
    	$respuesta = DB::connection('sqlsrv')->select(' exec sp_inf_campana ?',array($cod_campana));
        return $respuesta;
    }
}