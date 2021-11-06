<?php

namespace App\Http\Controllers;

use App\Iconos;
use App\Menu;
use App\Roles;
use App\RolPermiso;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PermisosController extends Controller
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

        $lstMenu = Menu::where('id_princ', '=', null)->get();
        $lstIconos = Iconos::where('estado', 'A')->get();
        return view('permisos.index', compact('lstMenu','lstIconos'));
    }


    public function viewData(Request $request)
    {
        try {
            $lstResult  = Menu::with('menuPadre')->orderBy('orden','asc')->get();
            return view('permisos.tabla', compact('lstResult'));
        } catch (Exception $e) {
            return "Ha ocurrido un problema al obtener la información " . $e->getMessage();
        }
    }



    public function save(Request $request)
    {
        try {
            if (!empty($request->hide_id)) {
                $messages = [
                    'txt_nombre.required' => 'Ingrese Nombre',
                    'txt_nombre.unique' => 'El nombre ya esta en uso.',
                    'txt_nombre.max' => 'El tamaño del nombre es max 150 caracteres.',
                ];

                $validator = Validator::make($request->all(), [
                    'txt_nombre' => 'required|max:150|unique:menu,nombre,' . $request->hide_id . ',id'
                ], $messages);

                $mensaje = '';

                if ($validator->fails()) {
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $obj = Menu::find($request->hide_id);
                    $obj->nombre = $request->txt_nombre;

                    if($request->chk_tipo == 'P'){
                        $obj->iconos = $request->cmb_iconos;
                        $obj->prefix = $request->prefijo;
                        $obj->id_princ = null;
                        $obj->link = null;
                    }else{
                        $obj->id_princ = $request->cmb_menu;
                        $obj->iconos = null;
                        $obj->prefix = null;
                    }

                    $obj->estado = ($request->chk_estado == 'on' ? 'A' : 'I');
                    $obj->fecha_creacion = date('Y-m-d h:i:s');
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
                    'txt_nombre' => 'required|max:50',
                ], $messages);

                $mensaje = '';

                if ($validator->fails()) {
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $obj = new Menu();
                    $obj->nombre = $request->txt_nombre;

                    if($request->chk_tipo == 'P'){
                        $obj->iconos = $request->cmb_iconos;
                        $obj->prefix = $request->prefijo;
                        $obj->id_princ = null;
                        $obj->link = null;
                    }else{
                        $obj->id_princ = $request->cmb_menu;
                        $obj->iconos = null;
                        $obj->prefix = null;
                    }

                    $obj->estado = ($request->chk_estado == 'on' ? 'A' : 'I');
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
            $obj = Menu::find($request->id);
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
            $obj = Menu::find($request->id);
            return ['msg' => 'success', 'info' => 'Se ha cargado información: ' . $obj->nombre, 'data' => $obj];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }
}
