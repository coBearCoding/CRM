<?php

namespace App\Http\Controllers;

use App\NivelPrimario;
use App\NivelSecundario;
use App\PreguntaEncuesta;
use App\TipoEncuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PreguntasEncuestasController extends Controller
{
    public function __construct()
    {
        $this->middleware('configure');
    }

    public function index()
    {
        $nivel_primario = NivelPrimario::where('estado', 'A')->get();
        $lstDatos = TipoEncuesta::where('estado', 'A')->get();
        return view('preguntas.index', compact('lstDatos','nivel_primario'));
    }

    public function viewData(Request $request)
    {
        $objinfoUser = Session::get('infoUser');
        $lstResult = PreguntaEncuesta::with('tipo')->with('nivel_primario')->where('empresa_id', $objinfoUser->empresa_id)->get();
        return view('preguntas.tabla', compact('lstResult'));
    }

    public function save(Request $request)
    {
        try {
            $objinfoUser = Session::get('infoUser');

            if (!empty($request->hide_id)) {
                $messages = [
                    'texto_pregunta.required' => 'Ingrese Nombre',
                    'texto_pregunta.unique' => 'El nombre ya esta en uso.',
                    'grupo.required' => 'Ingrese Grupo',
                    'tipo.required' => 'Ingrese Tipo de Pregunta',
                    'texto_pregunta.max' => 'El tamaño del nombre es max 150 caracteres.',
                ];

                $validator = Validator::make($request->all(), [
                    'texto_pregunta' => 'required|max:150',
                    'grupo' => 'required',
                    'tipo' => 'required'
                ], $messages);

                $mensaje = '';

                if ($validator->fails()) {
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $obj = PreguntaEncuesta::find($request->hide_id);
                    $obj->tipo_campo = $request->tipo;
                    $obj->texto = $request->texto_pregunta;
                    $obj->respuestas = $request->lst_resp;
                    $obj->tipo_encuesta_id = $request->grupo;
                    $obj->nivel_primario_id = $request->sl_nivelprimario;
                    $obj->estado = $request->estado;
                    $obj->empresa_id = $objinfoUser->empresa_id;
                    $obj->fecha_creacion = date('Y-m-d h:i:s');
                    $obj->save();

                    return response()->json(['msg' => 'success', 'data' => 'Se ha actualizado correctamente: ' . $request->texto_pregunta]);
                }
            } else {
                $messages = [
                    'texto_pregunta.required' => 'Ingrese Nombre',
                    'texto_pregunta.unique' => 'El nombre ya esta en uso.',
                    'grupo.required' => 'Ingrese Grupo',
                    'tipo.required' => 'Ingrese Tipo de Pregunta',
                    'texto_pregunta.max' => 'El tamaño del nombre es max 150 caracteres.',
                ];

                $validator = Validator::make($request->all(), [
                    'texto_pregunta' => 'required|max:150',
                    'grupo' => 'required',
                    'tipo' => 'required'
                ], $messages);

                $mensaje = '';

                if ($validator->fails()) {
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $obj = new PreguntaEncuesta();
                    $obj->tipo_campo = $request->tipo;
                    $obj->texto = $request->texto_pregunta;
                    $obj->respuestas = $request->lst_resp;
                    $obj->tipo_encuesta_id = $request->grupo;
                    $obj->nivel_primario_id = $request->sl_nivelprimario;
                    $obj->estado = $request->estado;
                    $obj->empresa_id = $objinfoUser->empresa_id;
                    $obj->fecha_creacion = date('Y-m-d h:i:s');
                    $obj->save();

                    return response()->json(['msg' => 'success', 'data' => 'Se ha guardado correctamente: ' . $request->texto_pregunta]);
                }
            }


        } catch (Exception $e) {
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
        }
    }

    public
    function delete(Request $request)
    {
        try {
            $obj = PreguntaEncuesta::find($request->id);
            $obj->estado = 'I';
            $obj->save();
            return ['msg' => 'success', 'data' => 'Se ha desactivado correctamente: ' . $obj->texto];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }

    public
    function edit(Request $request)
    {
        try {
            $obj = PreguntaEncuesta::find($request->id);
            return ['msg' => 'success', 'info' => 'Se ha cargado información: ' . $obj->texto, 'data' => $obj];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }
}
