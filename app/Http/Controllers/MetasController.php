<?php

namespace App\Http\Controllers;


use App\MediosGestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Campana;
use App\Sede;
use App\Periodo;
use App\Profile;
use App\NivelPrimario;
use App\NivelSecundario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\CampanasUsers;
use App\CampanasProgramas;
use App\CampanasSede;
use App\Metas;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Meta;

//use Validator;
//use Illuminate\Contracts\Validation\Validator;

class MetasController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $lstNivel1 = NivelPrimario::where('estado', '=', 'A')->get();
        $lstSede = Sede::where('estado', '=', 'A')->get();

        return view('metas.index', compact('lstNivel1', 'lstSede'));
    }

    public function viewData()
    {
        $lstMetas = Metas::with('sede')->get();
        return view('metas.tabla', compact('lstMetas'));
    }

    public function save(Request $request)
    {
        $mensaje = ['nombre.required' => 'Ingrese el nombre',
            'fch_inicio.required' => 'Ingrese la fecha de Inicio',
            'fch_fin.required' => 'Ingrese la Fecha de Finalización',
            'fch_fin.after_or_equal' => 'La Fecha de Finalización debe de ser mayor que la Fecha de Inicio',
            'sede_id.required' => 'Seleccione Sede',
            'nivel1_id.required' => 'Seleccione '. Session::get('nivel1'),
            'detalle.required' => 'Ingrese el detalle',
            'num_lead.required' => 'Ingrese el numero de Leads a alcanzar.',
            'num_cliente.required' => 'Ingrese el numero de Clientes a alcanzar'
        ];
        $validacion = Validator::make($request->all(), [
            'nombre' => 'required',
            'fch_inicio' => 'required',
            'fch_fin' => 'required|after_or_equal:fch_inicio',
            'detalle' => 'required',
            'sede_id' => 'required',
            'nivel1_id' => 'required',
            'num_lead' => 'required',
            'num_cliente' => 'required',
        ], $mensaje);

        if ($validacion->fails()) {
            $error = $validacion->errors();
            return array('data' => $error, 'msg' => 'error', 'opcion' => 'validar');
        }

        $objinfoUser = Session::get('infoUser');

        if (!empty($request->codigo_id)) {

            $countMetas = Metas::where('nombre', $request->nom_campana)->where('estado', 'A')->where('id', '!=', $request->cod_campana)->count();

            if ($countMetas > 0) {
                return array('data' => 'Error!! El nombre de la meta ya existe, ingrese otro', 'msg' => 'error');
            }

            $objMeta = Metas::find($request->codigo_id);
            $objMeta->nombre = $request->nombre;
            $objMeta->fecha_ini = $request->fch_inicio;
            $objMeta->fecha_fin = $request->fch_fin;
            $objMeta->estado = $request->estado;
            $objMeta->empresa_id = $objinfoUser->empresa_id;
            $objMeta->detalle = $request->detalle;
            $objMeta->sede_id = $request->sede_id;
            $objMeta->nprimario_id = $request->nivel1_id;
            $objMeta->num_lead = $request->num_lead;
            $objMeta->num_cliente = $request->num_cliente;
            $objMeta->save();

            return array('data' => 'Se ha actualizado correctamente: ' . $request->nombre, 'msg' => 'success');

        } else {

            $countMetas = Metas::where('nombre', $request->nom_campana)->where('estado', 'A')->count();

            if ($countMetas > 0) {
                return array('data' => 'Error!! El nombre de la meta ya existe, ingrese otro', 'msg' => 'error');
            }

            $objMeta = new Metas();
            $objMeta->nombre = $request->nombre;
            $objMeta->fecha_ini = $request->fch_inicio;
            $objMeta->fecha_fin = $request->fch_fin;
            $objMeta->estado = $request->estado;
            $objMeta->empresa_id = $objinfoUser->empresa_id;
            $objMeta->detalle = $request->detalle;
            $objMeta->nprimario_id = $request->nivel1_id;
            $objMeta->sede_id = $request->sede_id;
            $objMeta->num_lead = $request->num_lead;
            $objMeta->num_cliente = $request->num_cliente;
            $objMeta->save();

            return array('data' => 'Se ha guardado correctamente: ' . $request->nombre, 'msg' => 'success');
        }

    }

    public function delete(Request $request)
    {
        try {
            $obj = Metas::find($request->id);
            $obj->estado = 'I';
            $obj->save();
            return ['msg' => 'success', 'data' => 'Se ha eliminado correctamente: ' . $obj->nombre];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }

    public function edit(Request $request)
    {
        try {
            $obj = Metas::find($request->id);
            return ['msg' => 'success', 'info' => 'Se ha cargado información: ' . $obj->nombre, 'data' => $obj];
        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }
    }

}


