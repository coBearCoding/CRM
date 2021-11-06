<?php

namespace App\Http\Controllers;

use App\Roles;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
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

        return view('roles.roles');
    }


    public function save(Request $request)
    {
        try {
            if (!empty($request->hide_id)) {
                $messages = [
                    'txt_nombre.required' => 'Ingrese Nombre',
                    'txt_nombre.unique' => 'El nombre del rol ya esta en uso.',
                    'txt_nombre.max' => 'El tamaño del nombre es max 50 caracteres.',
                ];

                $validator = Validator::make($request->all(), [
                    'txt_nombre' => 'required|max:50|unique:roles,nombre,' . $request->hide_id,
                ], $messages);

                if ($validator->fails()) {
                    $mensaje = '';
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $rol = Roles::find($request->hide_id);
                    $rol->nombre = $request->txt_nombre;
                    //$rol->descripcion = $request->txt_descripcion;
                    $rol->estado = ($request->chk_estado == 'on' ? 'A' : 'I');
                    $rol->save();

                    return response()->json(['msg' => 'success', 'data' => 'Se ha actualizado correctamente el rol ' . $request->txt_nombre]);
                }
            } else {
                $messages = [
                    'txt_nombre.required' => 'Ingrese Nombre',
                    'txt_nombre.unique' => 'El nombre del rol ya esta en uso.',
                    'txt_nombre.max' => 'El tamaño del nombre es max 50 caracteres.',
                ];

                $validator = Validator::make($request->all(), [
                    'txt_nombre' => 'required|max:50|unique:roles,nombre',
                ], $messages);

                if ($validator->fails()) {
                    $mensaje = '';
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $rol = new Roles();
                    $rol->nombre = $request->txt_nombre;
                    $rol->estado = ($request->chk_estado == 'on' ? 'A' : 'I');
                    $rol->save();

                    return response()->json(['msg' => 'success', 'data' => 'Se ha guardado correctamente el rol ' . $request->txt_nombre]);
                }
            }


        } catch (Exception $e) {
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
        }
    }


    public function viewData()
    {
        try {

            $lstRol = Roles::all();
            return view('roles.tabla', compact('lstRol', $lstRol));
        } catch (Exception $e) {
            return "Ha ocurrido un problema al obtener la información " . $e->getMessage();
        }
    }

    public function delete(Request $request)
    {
        try {
            $rol = Roles::find($request->id);
            $rol->estado='I';
            $rol->save();
            return ['msg' => 'success', 'data' => 'Se ha eliminado correctamente el rol: ' . $rol->name];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }

    public function edit(Request $request)
    {
        try {
            $rol = Roles::find($request->id);
            return ['msg' => 'success', 'info' => 'Se ha cargado información del rol: ' . $rol->name, 'data' => $rol];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }
}
