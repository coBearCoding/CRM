<?php

namespace App\Http\Controllers;

use App\FuentesContacto;
use App\Iconos;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Support\Facades\Validator;

class FuentesContactoController extends Controller
{
    public function __construct()
    {
        $this->middleware('configure');
    }

    public function index()
    {

        $lstIconos = Iconos::where('estado', 'A')->get();
        return view('fcontacto.index', compact('lstIconos'));
    }

    public function viewData(Request $request)
    {

        $objinfoUser = Session::get('infoUser');
        $lsResult = FuentesContacto::where('empresa_id', $objinfoUser->empresa_id)->get();
        return view('fcontacto.tabla', compact('lsResult'));
    }

    public function save(Request $request)
    {
        try {
            $objinfoUser = Session::get('infoUser');

            if (!empty($request->hide_id)) {
                $messages = [
                    'txt_nombre.required' => 'Ingrese Nombre',
                    'txt_color.required' => 'Ingrese Color',
                    'cmb_iconos.required' => 'Seleccione Icono',
                    'txt_color.unique' => 'El color ya esta en uso.',
                    'txt_nombre.unique' => 'El nombre ya esta en uso.',
                    'cmb_iconos.unique' => 'El icono ya esta en uso.',
                ];

                $validator = Validator::make($request->all(), [
                    'txt_nombre' => 'required|max:50|unique:fuente_contacto,nombre,' . $request->hide_id . ',id',
                    'txt_color' => 'required|unique:fuente_contacto,color,' . $request->hide_id . ',id',
                    'cmb_iconos' => 'required|unique:fuente_contacto,icono,' . $request->hide_id . ',id',
                ], $messages);

                if ($validator->fails()) {
                    $mensaje = '';
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {

                    $obj = FuentesContacto::find($request->hide_id);
                    if (!empty($obj)) {
                        $obj->nombre = $request->txt_nombre;
                        $obj->estado = ($request->chk_estado == 'on' ? 'A' : 'I');
                        $obj->fecha_creacion = date('Y-m-d h:i:s');
                        $obj->icono = $request->cmb_iconos;
                        $obj->color = $request->txt_color;
                        $obj->empresa_id = $objinfoUser->empresa_id;
                        $obj->user_id = Auth::user()->id;
                        $obj->save();
                    }
                    return response()->json(['msg' => 'success', 'data' => 'Se ha actualizado correctamente de: ' . $request->txt_nombre]);
                }
            } else {
                $messages = [
                    'txt_nombre.required' => 'Ingrese Nombre',
                    'txt_color.required' => 'Ingrese Color',
                    'cmb_iconos.required' => 'Seleccione Icono',
                    'txt_color.unique' => 'El color ya esta en uso.',
                    'txt_nombre.unique' => 'El nombre ya esta en uso.',
                    'cmb_iconos.unique' => 'El icono ya esta en uso.',
                ];

                $validator = Validator::make($request->all(), [
                    'txt_nombre' => 'required|max:50|unique:fuente_contacto,nombre',
                    'txt_color' => 'required|unique:fuente_contacto,color',
                    'cmb_iconos' => 'required|unique:fuente_contacto,icono',
                ], $messages);

                if ($validator->fails()) {
                    $mensaje = '';
                    foreach ($validator->errors()->all() as $error) {
                        $mensaje .= '<li>' . $error . '</li>';
                    }
                    return response()->json(['msg' => 'error', 'data' => $mensaje]);
                } else {
                    $obj = new FuentesContacto();
                    $obj->nombre = $request->txt_nombre;
                    $obj->estado = ($request->chk_estado == 'on' ? 'A' : 'I');
                    $obj->fecha_creacion = date('Y-m-d h:i:s');
                    $obj->icono = $request->cmb_iconos;
                    $obj->color = $request->txt_color;
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
            $obj = FuentesContacto::find($request->id);
            $obj->estado = 'I';
            $obj->save();
            return ['msg' => 'success', 'data' => 'Se ha desactivado correctamente: ' . $obj->nom_fuente_contacto];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }

    public function edit(Request $request)
    {
        try {
            $obj = FuentesContacto::find($request->id);
            return ['msg' => 'success', 'info' => 'Se ha cargado información de: ' . $obj->nom_fuente_contacto, 'data' => $obj];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }

}
