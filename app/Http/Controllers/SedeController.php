<?php

namespace App\Http\Controllers;

use App\Roles;
use App\Sede;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class SedeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('configure');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('sedes.sedes');
    }


    public function save(Request $request)
    {
        try {
            if (!empty($request->hide_id)) {
                $messages = [
                    'txt_nombre.required' => 'Ingrese Nombre',
                    'txt_nombre.unique' => 'El nombre de la sede ya esta en uso.',
                    'txt_nombre.max' => 'El tamaño del nombre es max 50 caracteres.',
                ];

                $validator = Validator::make($request->all(), [
                    'txt_nombre' => 'required|max:50|unique:sede,nombre,' . $request->hide_id,
                ], $messages);

                if ($validator->fails()) {
                    $mensaje = '';
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $rol = Sede::find($request->hide_id);
                    $rol->nombre = $request->txt_nombre;
                    $rol->estado = ($request->chk_estado == 'on' ? 'A' : 'I');
                    $rol->save();

                    return response()->json(['msg' => 'success', 'data' => 'Se ha actualizado correctamente:  ' . $request->txt_nombre]);
                }
            } else {
                $messages = [
                    'txt_nombre.required' => 'Ingrese Nombre',
                    'txt_nombre.unique' => 'El nombre del rol ya esta en uso.',
                    'txt_nombre.max' => 'El tamaño del nombre es max 50 caracteres.',
                ];

                $validator = Validator::make($request->all(), [
                    'txt_nombre' => 'required|max:50|unique:sede,nombre',
                ], $messages);

                if ($validator->fails()) {
                    $mensaje = '';
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $sede = Sede::all();
                    $codigo = $sede->last();
                    $rol = new Sede();
                    $rol->id= $codigo->id+1; 
                    $rol->nombre = $request->txt_nombre;
                    $rol->estado = ($request->chk_estado == 'on' ? 'A' : 'I');
                    $rol->save();

                    return response()->json(['msg' => 'success', 'data' => 'Se ha guardado correctamente: ' . $request->txt_nombre]);
                }
            }


        } catch (Exception $e) {
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
        }
    }


    public function viewData()
    {
        try {
            $lstInfo = Sede::all();
            return view('sedes.tabla', compact('lstInfo', $lstInfo));
        } catch (Exception $e) {
            return "Ha ocurrido un problema al obtener la información " . $e->getMessage();
        }
    }

    public function delete(Request $request)
    {
        try {
            $info = Sede::find($request->id);
            $info->estado = 'I';
            $info->save();
            return ['msg' => 'success', 'data' => 'Se ha eliminado correctamente: ' . $info->name];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }

    public function edit(Request $request)
    {
        try {
            $info = Sede::find($request->id);
            return ['msg' => 'success', 'info' => 'Se ha cargado información: ' . $info->nombre, 'data' => $info];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }
}
