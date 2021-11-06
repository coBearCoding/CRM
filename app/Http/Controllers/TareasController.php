<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tareas;

class TareasController extends Controller
{
     public function __construct() {
		$this->middleware('configure');
	}

    public function index()
    {
       	return view('tareas.index');
    }

    public function data(Request $request)
    {

        return datatables()
            ->eloquent(Tareas::with('usuario')->where('tarea.st_tarea','A'))
            ->addColumn('opciones','tareas.opciones') #detalle o llave a recibir en el JS y segundo campo la vista
        	->rawColumns(['opciones']) #opcion para que presente el HTML
            ->toJson();
    }

}
