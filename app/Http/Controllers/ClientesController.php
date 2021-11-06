<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmailTrans;
use App\Campana;
use App\NivelPrimario;
use App\FuentesContacto;
use App\Clientes;
use App\Estados;

class ClientesController extends Controller
{
    public function __construct() {
		$this->middleware('configure');
	}

    public function index()
    {
        $emails_trans = EmailTrans::where('st_email','A')->get();
        $campanas = Campana::where('estado','A')->get();
        $nivel_primario = NivelPrimario::where('estado','A')->get(); //oferta academica
        $fuente_contactos = FuentesContacto::where('st_fuente_contacto','A')->get();
    	return view('clientes.index',compact('emails_trans','campanas','nivel_primario','fuente_contactos'));
    }

    public function data(Request $request)
    {
        $estados =  Estados::where('tipo','c')->get();

        return datatables()
            ->eloquent(Clientes::with('programa')->with('oferta_academica')->where('clientes.st_cliente','A'))
            ->addColumn('datos','clientes.datos') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('opciones','clientes.opciones') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('estado', function($arrProduct)use(&$estados){
            	$select = '<select class="form-control">';
            	foreach ($estados as $key => $value) {
            		$select .= '<option id="'.$value->sigla.'">'.$value->nombre.'</option>';
            	}
            	$select .= '</select>';
	          	return $select;
	        })
        	->rawColumns(['datos','estado','opciones']) #opcion para que presente el HTML
            ->toJson();
    }
}
