<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NivelPrimario;
use App\Horario;
use App\Dia;

class HorarioController extends Controller
{
    public function index()
    {
    	$servicios = NivelPrimario::where('estado','A')->get();
    	$dias = Dia::all();
    	return view('horarios.index',compact('dias','servicios'));
    }

    public function data(Request $request)
    {
    	$results = NivelPrimario::where('estado','A')->get();
    	return view('horarios.table',compact('results'));
    }

    public function detalle(Request $request)
    {
    	return Horario::with('servicio')->with('dia')->where('estado','A')->where('servicio_id',$request->id)->get();
    }

    public function register(Request $request)
    {
    	//return $request;
    	if (empty($request->id)) {
    		$verificar = Horario::where('servicio_id',$request->servicio)->where('dia_id',$request->dia)->first();
	    	if (!empty($verificar)) {
	    		return response()->json(['msg' => 'error', 'data' => 'Usted ya configuro el horario para este día ']);
	    	}
    	}
    	$horario = Horario::find($request->id);
    	if (empty($horario)) {
            $horario = new horario;
            $horario->servicio_id =  $request->servicio;
            $horario->dia_id =  $request->dia;
            $horario->hora_ini =  $request->hora_ini;
            $horario->hora_fin =  $request->hora_fin;
            $horario->descanso_ini =  $request->descanso_ini;
            $horario->descanso_fin =  $request->descanso_fin;
            $horario->intervalo =  $request->intervalo;
            $horario->max_turno =  $request->max_turno;
            $horario->save();
            return response()->json(['msg' => 'success', 'data' => 'Se ha creado correctamente el horario ']);
        }else{
            //$horario->servicio_id =  $request->servicio;
            //$horario->dia_id =  $request->dia;
            $horario->hora_ini =  $request->hora_ini;
            $horario->hora_fin =  $request->hora_fin;
            $horario->descanso_ini =  $request->descanso_ini;
            $horario->descanso_fin =  $request->descanso_fin;
            $horario->intervalo =  $request->intervalo;
            $horario->max_turno =  $request->max_turno;
            $horario->save();
            return response()->json(['msg' => 'success', 'data' => 'Se ha actualizado correctamente el horario ']);
        }
    }


}
