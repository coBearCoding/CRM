<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Exports\AsesorEstado;
use App\Exports\Seguimiento;
use App\Exports\FuenteContactoEstado;
use App\Exports\Contacto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\EstadoComercial;
use App\TipoContacto;
use App\ContactoHistorico;
use App\Exports\NoInteresado;
use App\Exports\SeguimientoPorEstados;
use App\FuentesContacto;
use App\NivelPrimario;
use App\NivelSecundario;
use App\PermisosNPrimario;
use Maatwebsite\Excel\Facades\Excel;

class GestionController extends Controller
{
    protected $objinfoUser;
    protected $permiso_np;

    public function __construct() {
		$this->middleware('configure');
        $this->middleware(function ($request, $next){
            $this->objinfoUser = Session::get('infoUser');
            $this->permiso_np = Session::get('permiso_np');
            return $next($request);
        });
    }

    public function index(){

        $estado_comercial = EstadoComercial::where('tipo', 'L')->get();
        $FuentesContactos = FuentesContacto::all();
        //$NivelPrimarios = NivelPrimario::where('estado','A')->get();
        $NivelPrimarios = PermisosNPrimario::with('nprimario')->where('user_id', $this->objinfoUser->user_id)->get();
    	return view('reportes.gestion',compact('estado_comercial','FuentesContactos','NivelPrimarios'));
    }

    public function loadNSecundario(Request $request)
    {
        return NivelSecundario::where('nprimario_id',$request->id)->get();
    }

    public function rptSeguimiento(Request $request)
    {
        /* $estado_comercial = implode(',',$request->estado_comercial);
        $nivel_primario = 0;
        $nivel_secundario = 0;
        if(empty($request->oferta_academica_r)){
            $nivel_primario = isset($this->permiso_np) ? implode(',',$this->permiso_np) : 0;
        }else{
            $nivel_primario = $request->oferta_academica_r;
        }
        if(!empty($request->programa_r)){
            $nivel_secundario = $request->programa_r;
        } */
        //return $request;
        $empresa = Empresa::find(1);
        $estados = EstadoComercial::where('tipo','L')->get();
        $datos = DB::select('exec sp_reporte_seguimiento_leads ?,?',[$request->fecha_ini. ' 00:00:00',$request->fecha_fin. ' 23:59:59']);
        if ($request->reporte == 'excel') {
            $fecha_inicio = $request->fecha_ini;
            $fecha_fin = $request->fecha_fin;
            /* return view('exportar.seguimiento_xls', [
                'datos' => $datos,
                'empresa' => $empresa,
                'estados' => $estados,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin
            ]); */
             return Excel::download(new Seguimiento($datos,$empresa,$estados,$request->fecha_ini,$request->fecha_fin), 'rpt_seguimiento.xlsx');
        }else{
            $fecha_inicio = $request->fecha_ini;
            $fecha_fin = $request->fecha_fin;
            $pdf = \PDF::loadView('exportar.seguimiento_pdf', compact('datos','empresa','estados','fecha_inicio','fecha_fin'))->setPaper('A4', 'landscape');;
            //return $pdf->download('rpt_vendedor_estado_comercial.pdf');
            return $pdf->stream('rpt_seguimiento.pdf');
        }
    }

    public function rptEstadoComercial(Request $request)
    {
        $estado_comercial = implode(',',$request->estado_comercial);
        $nivel_primario = 0;
        $nivel_secundario = 0;
        if(empty($request->oferta_academica_r)){
            $nivel_primario = isset($this->permiso_np) ? implode(',',$this->permiso_np) : 0;
        }else{
            $nivel_primario = $request->oferta_academica_r;
        }
        if(!empty($request->programa_r)){
            $nivel_secundario = $request->programa_r;
        }
        //return $request;
        $empresa = Empresa::find(1);
        $estados = EstadoComercial::where('tipo','L')->get();
        $datos = DB::select('exec sp_vendedor_estado_comercial ?,?,?,?,?,?',[1,$estado_comercial,$request->fecha_ini. ' 00:00:00',$request->fecha_fin. ' 23:59:59',$nivel_primario,$nivel_secundario]);
        if ($request->reporte == 'excel') {
            /* return view('exportar.estado_xls', [
                'datos' => $datos,
                'empresa' => $empresa,
                'estados' => $estados
            ]); */
             return Excel::download(new AsesorEstado($datos,$empresa,$estados,$request->fecha_ini,$request->fecha_fin), 'rpt_vendedor_estado_comercial.xlsx');
        }else{
            $fecha_inicio = $request->fecha_ini;
            $fecha_fin = $request->fecha_fin;
            $pdf = \PDF::loadView('exportar.estado', compact('datos','empresa','estados','fecha_inicio','fecha_fin'))->setPaper('A4', 'landscape');;
            //return $pdf->download('rpt_vendedor_estado_comercial.pdf');
            return $pdf->stream('rpt_vendedor_estado_comercial.pdf');
        }
    }

    public function rptFuenteContactoEstado(Request $request)
    {
        //return $request;
        $estado_comercial = implode(',',$request->estado_comercial);
        $nivel_primario = 0;
        $nivel_secundario = 0;
        if(empty($request->oferta_academica_r)){
            $nivel_primario = isset($this->permiso_np) ? implode(',',$this->permiso_np) : 0;
        }else{
            $nivel_primario = $request->oferta_academica_r;
        }
        if(!empty($request->programa_r)){
            $nivel_secundario = $request->programa_r;
        }
        $empresa = Empresa::find(1);
        $estados = EstadoComercial::where('tipo','L')->get();
        $datos = DB::select('exec sp_fuente_contacto_estado ?,?,?,?,?,? ',[1,$estado_comercial,$request->fecha_ini. ' 00:00:00',$request->fecha_fin. ' 23:59:59',$nivel_primario,$nivel_secundario ]);
        if ($request->reporte == 'excel') {
            return view('exportar.fuenteContacto', [
                'datos' => $datos,
                'empresa' => $empresa,
                'estados' => $estados
            ]);
            return Excel::download(new FuenteContactoEstado($datos,$empresa,$estados), 'rpt_fte_contacto_estado_comercial.xlsx');
        }else{
            $pdf = \PDF::loadView('exportar.fuenteContacto', compact('datos','empresa','estados'));
            return $pdf->stream('rpt_fte_contacto_estado_comercial.pdf');
        }
    }

    public function rptNoInteresado(Request $request)
    {
        $empresa = Empresa::find(1);
        $estados = EstadoComercial::where('tipo','L')->get();
        $datos = DB::select('exec sp_reporte_no_interesados_leads ?,?,?,?',[
            $request->oferta_academica_r,
            $request->programa,
            $request->fecha_ini. ' 00:00:00',
            $request->fecha_fin. ' 23:59:59']);
        if ($request->reporte == 'excel') {
            $fecha_inicio = $request->fecha_ini;
            $fecha_fin = $request->fecha_fin;
             return Excel::download(new NoInteresado($datos,$empresa,$estados,$request->fecha_ini,$request->fecha_fin), 'rpt_NoInteresado.xlsx');
        }else{
            $fecha_inicio = $request->fecha_ini;
            $fecha_fin = $request->fecha_fin;
            $pdf = \PDF::loadView('exportar.NoInteresado_pdf', compact('datos','empresa','estados','fecha_inicio','fecha_fin'))->setPaper('A4', 'landscape');;
            return $pdf->stream('rpt_seguimiento.pdf');
        }
    }

    public function rptSeguimientoPorEstados(Request $request)
    {
        $empresa = Empresa::find(1);
        $estados = EstadoComercial::where('tipo','L')->get();
        $datos = DB::select('exec sp_reporte_seguimiento_estado_leads ?,?,?,?',[
            $request->oferta_academica_r,
            $request->programa,
            $request->fecha_ini. ' 00:00:00',
            $request->fecha_fin. ' 23:59:59']);
        if ($request->reporte == 'excel') {
            $fecha_inicio = $request->fecha_ini;
            $fecha_fin = $request->fecha_fin;
             return Excel::download(new SeguimientoPorEstados($datos,$empresa,$estados,$request->fecha_ini,$request->fecha_fin), 'rpt_NoInteresado.xlsx');
        }else{
            $fecha_inicio = $request->fecha_ini;
            $fecha_fin = $request->fecha_fin;
            $pdf = \PDF::loadView('exportar.SeguimientoPorEstados_pdf', compact('datos','empresa','estados','fecha_inicio','fecha_fin'))->setPaper('A4', 'landscape');;
            return $pdf->stream('rpt_seguimiento.pdf');
        }
    }

    public function reporte(Request $request)
    {
        if ($request->tipo_reporte==1) { //estado de comercializacion vendedor
            return $this->rptEstadoComercial($request);
        }elseif ($request->tipo_reporte==2) { //Por fuente de contacto
            return $this->rptFuenteContactoEstado($request);
        }elseif ($request->tipo_reporte==3) { //Por seguimiento
            return $this->rptSeguimiento($request);
        }elseif ($request->tipo_reporte==4) { //Por No interesado
            return $this->rptNoInteresado($request);
        }elseif ($request->tipo_reporte==5) { //Por estados de seguimiento
            return $this->rptSeguimientoPorEstados($request);
        }
    }

    public function contacto(Request $request)
    {
       // return $request;
        $empresa = Empresa::find(1);
        //DB::enableQueryLog(); // Enable query log
###########
          $datos = ContactoHistorico::with('contacto_tipo')
                ->whereHas('contacto_tipo', function ($query)  use ($request) {
                    $query->where('tipo_id', $request->tipo_contacto); #leads
                })
                ->with('motivo_desinteres')
                ->with('contacto_tipo.contacto')
                ->with('contacto_tipo.desinteres')
                ->with('contacto_tipo.auditoria_last')
                ->with('contacto_tipo.contacto.creado_por')
                ->with('fuente_contacto')
                ->with('campana_programa')
                ->whereHas('campana_programa', function ($query) use ($request) {
                    if ($request->programa) {
                        $query->where('nsecundario_id', $request->programa);
                    }else{
                        $query;
                    }
                })
                ->with('campana_programa.programa')
                ->whereHas('campana_programa.programa', function ($query) use ($request) {
                    if ($request->oferta_academica) {
                        $query->where('nprimario_id', $request->oferta_academica);
                    }else{
                        $query;
                    }
                })
                ->with('campana_programa.campana')
                ->with('estado_comercial')
                ->with('vendedor')
                ->with('creado_por')
                ->whereIn('id', function ($sub) {
                    $sub->selectRaw('max(id)')->from('contacto_historicos')->groupBy('contacto_tipo_id'); // <---- la clave
                })
                ->whereBetween('created_at',[$request->fecha_ini_lc.' 00:00:00', $request->fecha_fin_lc.' 23:59:59'])
                ->when($request->estado_comercial_lc, function ($query) use ($request) {
                    $query->where('estado_comercial_id', $request->estado_comercial_lc);
                })
                ->when($request->fuente_contacto, function ($query) use ($request) {
                    $query->where('fuente_contacto_id', $request->fuente_contacto);
                })->get();
###########

           // return dd(DB::getQueryLog()); // Show results of log
                $tipo = $request->tipo_contacto == 1 ? 'leads' : 'clientes';

        if ($request->reporte_lc == 'excel') {
             return Excel::download(new Contacto($datos,$empresa), "rpt_".$tipo.".xlsx");
        }else{
            $pdf = \PDF::loadView('exportar.contacto', compact('datos','empresa'));
            return $pdf->stream("rpt_".$tipo.".pdf");
        }
    }

}
