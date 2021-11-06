<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NivelPrimario;
use App\Documento;
use App\TipoDocumento;

class DocumentoController extends Controller
{
    public function index()
    {
    	$servicios = NivelPrimario::where('estado','A')->get();
    	$tipos_documentos = TipoDocumento::all();
    	return view('documentos.index',compact('servicios','tipos_documentos'));
    }

    public function data(Request $request)
    {
    	$results = Documento::with('servicio')->with('tipo_documento')->get();
    	//return $results;
    	return view('documentos.table',compact('results'));
    }

    public function register(Request $request)
    {
    	$documento = Documento::find($request->id);
    	if (empty($documento)) {
    		$documento = new Documento;
    		$documento->servicio_id = $request->servicio;
    		$documento->nombre = $request->nombre;
    		$documento->tipo_documento_id = $request->tipo;
    		$documento->requerido = $request->requerido;
    		$documento->save();

    		$result = $documento ? ['msg' => 'success', 'data' => 'Se ha creado correctamente el documento '] : ['msg' => 'error', 'data' => 'Ocurrio un error al registrar el documento'];
    		return response()->json($result);
    	}else{
    		//$documento->servicio_id = $request->servicio;
    		$documento->nombre = $request->nombre;
    		$documento->tipo_documento_id = $request->tipo;
    		$documento->requerido = $request->requerido;
    		$documento->save();

    		$result = $documento ? ['msg' => 'success', 'data' => 'Se ha modificado correctamente el documento '] : ['msg' => 'error', 'data' => 'Ocurrio un error al modificado el documento'];
    		return response()->json($result);
    	}
    }
}
