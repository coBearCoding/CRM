<?php

namespace App\Http\Controllers;

use App\MediosGestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MediosContactoController extends Controller
{
    public function __construct()
    {
        $this->middleware('configure');
    }

    public function index()
    {
        return view('mgestion.index');
    }

    public function viewData(Request $request)
    {

        $objinfoUser = Session::get('infoUser');
        $lstResult = MediosGestion::where('empresa_id', $objinfoUser->empresa_id)->get();
        return view('mgestion.tabla', compact('lstResult'));
    }

    public function save(Request $request)
    {
        try {
            $objinfoUser = Session::get('infoUser');

            if (!empty($request->hide_id)) {
                $messages = [
                    'txt_nombre.required' => 'Ingrese Nombre',
                    'txt_nombre.unique' => 'El nombre ya esta en uso.',
                    'txt_nombre.max' => 'El tamaño del nombre es max 50 caracteres.',
                ];

                $validator = Validator::make($request->all(), [
                    'txt_nombre' => 'required|max:50|unique:medios_gestion,nombre,' . $request->hide_id . ',id'
                ], $messages);

                if ($validator->fails()) {
                    $mensaje = '';
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $obj = MediosGestion::find($request->hide_id);
                    $obj->nombre = $request->txt_nombre;
                    $obj->estado = ($request->chk_estado == 'on' ? 'A' : 'I');
                    $obj->empresa_id = $objinfoUser->empresa_id;
                    $obj->user_id = Auth::user()->id;
                    $obj->save();

                    return response()->json(['msg' => 'success', 'data' => 'Se ha actualizado correctamente: ' . $request->txt_nombre]);
                }
            } else {
                $messages = [
                    'txt_nombre.required' => 'Ingrese Nombre',
                    'txt_nombre.unique' => 'El nombre ya esta en uso.',
                    'txt_nombre.max' => 'El tamaño del nombre es max 50 caracteres.',
                ];

                $validator = Validator::make($request->all(), [
                    'txt_nombre' => 'required|max:50|unique:medios_gestion,nombre',
                ], $messages);

                if ($validator->fails()) {
                    $mensaje = '';
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $obj = new MediosGestion();
                    $obj->nombre = $request->txt_nombre;
                    $obj->estado = ($request->chk_estado == 'on' ? 'A' : 'I');
                    $obj->empresa_id = $objinfoUser->empresa_id;
                    $obj->user_id = Auth::user()->id;
                    $obj->save();

                    return response()->json(['msg' => 'success', 'data' => 'Se ha guardado correctamente: ' . $request->txt_nombre]);
                }
            }


        } catch (Exception $e) {
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $obj = MediosGestion::find($request->id);
            $obj->estado = 'I';
            $obj->save();
            return ['msg' => 'success', 'data' => 'Se ha eliminado correctamente: ' . $obj->nom_medio_gestion];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }

    public function edit(Request $request)
    {
        try {
            $obj = MediosGestion::find($request->id);
            return ['msg' => 'success', 'info' => 'Se ha cargado información: ' . $obj->nom_medio_gestion, 'data' => $obj];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }
}
