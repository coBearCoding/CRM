<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Roles;
use App\RolPermiso;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PermisosRolController extends Controller
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

        $lstRoles = Roles::where('estado', 'A')->get();
        return view('permisos_rol.permisos_rol', compact('lstRoles'));
    }


    public function viewData(Request $request)
    {
        try {
            $lstRol = Roles::where('estado', 'A')->get();
            $lstMenu = DB::select("exec sp_rol_permisos_all ?", array($request->rol));
            return view('permisos_rol.tabla', compact('lstMenu', 'lstRol'));
        } catch (Exception $e) {
            return "Ha ocurrido un problema al obtener la información " . $e->getMessage();
        }
    }

    public function edit(Request $request)
    {
        try {
            $messages = [
                'rol.required' => 'Ingrese Rol',
                'lstRol.required' => 'Ingrese Permisos del rol.',
            ];

            $validator = Validator::make($request->all(), [
                'rol' => 'required',
                'lstRol' => 'required',
            ], $messages);

            if ($validator->fails()) {
                $mensaje = '';
                foreach ($validator->errors()->all() as $error) {
                    $mensaje .= '<li>' . $error . '</li>';
                }
                return response()->json(['msg' => 'error', 'data' => $mensaje]);
            } else {

                $rolStatus = RolPermiso::where('rol_id', $request->rol)
                    ->update(['estado' => 'I']);
                $lstPermiso = $request->lstRol;

                foreach ($lstPermiso as $menu) {
                    $objPermiso = RolPermiso::where('rol_id', $request->rol)->where('menu_id', $menu)->first();

                    $objPrincipal = Menu::find($menu);

                    if(!empty($objPrincipal)){
                        $objPermisoPadre = RolPermiso::where('rol_id', $request->rol)
                            ->where('menu_id', $objPrincipal->id_princ)
                            ->first();

                        if(empty($objPermisoPadre)){
                            $permisoPadre = new RolPermiso();
                            $permisoPadre->estado = 'A';
                            $permisoPadre->rol_id = $request->rol;
                            $permisoPadre->menu_id = $objPrincipal->id_princ;
                            $permisoPadre->user_id = Auth::user()->id;
                            $permisoPadre->fecha_ingreso = date('Y-m-d h:i:s');
                            $permisoPadre->save();
                        }else{
                            $objPermisoPadre->estado = 'A';
                            $objPermisoPadre->user_id = Auth::user()->id;
                            $objPermisoPadre->fecha_ingreso = date('Y-m-d h:i:s');
                            $objPermisoPadre->save();
                        }
                    }

                    if(empty($objPermiso)){
                        $permiso = new RolPermiso();
                        $permiso->estado = 'A';
                        $permiso->rol_id = $request->rol;
                        $permiso->menu_id = $menu;
                        $permiso->user_id = Auth::user()->id;
                        $permiso->fecha_ingreso = date('Y-m-d h:i:s');
                        $permiso->save();
                    }else{
                        $objPermiso->estado = 'A';
                        $objPermiso->user_id = Auth::user()->id;
                        $objPermiso->fecha_ingreso = date('Y-m-d h:i:s');
                        $objPermiso->save();
                    }


                }

            }
            return ['msg' => 'success', 'data' => 'Se ha insertado los permisos del rol.'];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }
}
