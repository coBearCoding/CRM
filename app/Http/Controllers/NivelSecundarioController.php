<?php

namespace App\Http\Controllers;

use App\NivelPrimario;
use App\NivelSecundario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class NivelSecundarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('configure');
    }

    public function index()
    {
        $lstDatos = NivelPrimario::where('estado', 'A')->get();
        return view('nsecundario.index', compact('lstDatos'));
    }

    public function viewData(Request $request)
    {
        $objinfoUser = Session::get('infoUser');
        $lstResult = NivelSecundario::with('nivelprimario')->where('empresa_id', $objinfoUser->empresa_id)->get();
        return view('nsecundario.tabla', compact('lstResult'));
    }

    public function save(Request $request)
    {
        try {
            $objinfoUser = Session::get('infoUser');

            if (!empty($request->hide_id)) {
                $messages = [
                    'txt_nombre.required' => 'Ingrese Nombre',
                    'txt_nombre.unique' => 'El nombre ya esta en uso.',
                    'cmb_nprimario.required' => 'Ingrese ' . session('nivel1'),
                    'txt_nombre.max' => 'El tamaño del nombre es max 150 caracteres.',
                ];

                $validator = Validator::make($request->all(), [
                    'txt_nombre' => 'required|max:150',
                    'cmb_nprimario' => 'required'
                ], $messages);

                $mensaje = '';

                $lstDa = NivelSecundario::where('nombre', $request->txt_nombre)
                    ->where('nprimario_id', $request->cmb_nprimario)
                    ->where('id', '!=', $request->hide_id)->get();

                if (count($lstDa) > 0) {
                    $mensaje = 'El nombre ya se encuentra en uso para la '.session('nivel1');
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                }

                if ($validator->fails()) {
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $obj = NivelSecundario::find($request->hide_id);
                    $obj->nombre = $request->txt_nombre;
                    $obj->nprimario_id = $request->cmb_nprimario;
                    $obj->estado = ($request->chk_estado == 'on' ? 'A' : 'I');
                    $obj->empresa_id = $objinfoUser->empresa_id;
                    $obj->sendinblue_id = $request->cmb_template ?? '';
                    $obj->user_id = Auth::user()->id;
                    $obj->fecha_creacion = date('Y-m-d h:i:s');
                    $obj->save();

                    return response()->json(['msg' => 'success', 'data' => 'Se ha actualizado correctamente: ' . $request->txt_nombre]);
                }
            } else {
                $messages = [
                    'txt_nombre.required' => 'Ingrese Nombre',
                    'txt_nombre.unique' => 'El nombre ya esta en uso.',
                    'cmb_nprimario.required' => 'Ingrese ' . session('nivel1'),
                    'txt_nombre.max' => 'El tamaño del nombre es max 50 caracteres.',
                ];

                $validator = Validator::make($request->all(), [
                    'txt_nombre' => 'required|max:50',
                    'cmb_nprimario' => 'required',
                ], $messages);

                $mensaje = '';

                $lstDa = NivelSecundario::where('nombre', $request->txt_nombre)->where('nprimario_id', $request->cmb_nprimario)->get();
                if (count($lstDa) > 0) {
                    $mensaje = 'El nombre ya se encuentra en uso para la '.session('nivel1');
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                }

                if ($validator->fails()) {
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $obj = new NivelSecundario();
                    $obj->nombre = $request->txt_nombre;
                    $obj->nprimario_id = $request->cmb_nprimario;
                    $obj->estado = ($request->chk_estado == 'on' ? 'A' : 'I');
                    $obj->empresa_id = $objinfoUser->empresa_id;
                    $obj->sendinblue_id = $request->cmb_template ?? '';
                    $obj->user_id = Auth::user()->id;
                    $obj->fecha_creacion = date('Y-m-d h:i:s');
                    $obj->save();

                    return response()->json(['msg' => 'success', 'data' => 'Se ha guardado correctamente: ' . $request->txt_nombre]);
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
            $obj = NivelSecundario::find($request->id);
            $obj->estado = 'I';
            $obj->save();
            return ['msg' => 'success', 'data' => 'Se ha desactivado correctamente: ' . $obj->nombre];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }

    public
    function edit(Request $request)
    {
        try {
            $obj = NivelSecundario::find($request->id);
            return ['msg' => 'success', 'info' => 'Se ha cargado información: ' . $obj->nombre, 'data' => $obj];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }
}
