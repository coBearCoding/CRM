<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SolicitudEstado;
use App\SolicitudHistorial;
use App\Solicitud;
use App\Postulante;
use App\Documento;
use App\SolicitudDocumento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendEstado;
use App\Mail\SendCredencialAtrium;
use Illuminate\Support\Facades\Mail;
use App\Exports\SolicitudesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\Helper;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class SolicitudController extends Controller
{
    public function index()
    {
    	$solucitudEstados = SolicitudEstado::where('estado', 'A')->get();
    	return view('solicitudes.index', compact('solucitudEstados'));
    }

    public function data(Request $request)
    {
        $datos = DB::select('EXEC sp_data_solicitudes ?, ?, ?',[
        $request->fecha_ini,
        $request->fecha_fin,
        $request->estado]);
       return datatables($datos)
       ->toJson();
    }

    public function estado(Request $request)
    {
    	$solictud = DB::table('solicitud')
            ->where('id', $request->id_solicitud)
            ->update(['estado_id' => $request->estado_edit]);

        $objSolHistorial = new SolicitudHistorial();
        $objSolHistorial->solicitud_id = $request->id_solicitud;
        $objSolHistorial->user_id =  Auth::user()->id;
        $objSolHistorial->fecha = date('Y-m-d h:i:s');
        $objSolHistorial->ip = $_SERVER['REMOTE_ADDR'];
        $objSolHistorial->observaciones = $request->observacion_edit;
        $objSolHistorial->save();

        $solicitud_datos = Solicitud::with('postulante')->with('solicitud_estado')->where('id',$request->id_solicitud)->first();

        if (!empty($objSolHistorial) && !empty($solicitud_datos) && !empty($solicitud_datos->postulante->email) && $request->informar == 'S') {
                    Mail::to($solicitud_datos->postulante->email)->send(new SendEstado($solicitud_datos,$solicitud_datos->solicitud_estado->nombre));
                }


        $result = $objSolHistorial ? ['msg' => 'success', 'data' => 'Se ha creado actualizado el estado de la solicitud '] : ['msg' => 'error', 'data' => 'Ocurrio un error al actulizar el estado la solicitud '];

        return response()->json($result);
    }

    public function reporte(Request $request)
    {
        try {
            return Excel::download(new SolicitudesExport($request->fecha_ini, $request->fecha_fin, $request->estado_export), 'rpt_solicitud.xlsx');
        } catch (\Exception $e) {
            dd('Ha ocurrido un error', $e->getMessage());
        }
    }

    public function historial(Request $request)
    {
        $datos = SolicitudHistorial::with('SolicitudEstado')->where('solicitud_id', $request->id_solicitud)->orderBy('solicitud_historial.fecha', 'DESC')->get();
        return view('solicitudes.historial', compact('datos'));
    }

    public function documentos(Request $request)
    {
        //$solicitud =  Solicitud::with('postulante')->with('datos_adicional')->with('documentos')->find($request->id_solicitud);
         $solicitud =  Solicitud::with('postulante')->with('documentos')->find($request->id_solicitud);
        $documentos = Documento::with('servicio')->with('tipo_documento')->where('documentos.servicio_id',$solicitud->servicio_id)->where('documentos.estado',"A")->get();

        $postulante = DB::table('postulante')
        ->join('solicitud', 'postulante.id', '=', 'solicitud.postulante_id')
        ->select('postulante.*')
        ->where('solicitud.id', $request->id_solicitud)
        ->first();

        $migrado = !empty($postulante->codigo_alumno) ? "S" : "N";
        $codigo = $solicitud->cod_solicitud;
        return view('solicitudes.documentos',compact('documentos','solicitud', 'migrado', 'postulante', 'codigo'));
    }

    public function descargarDocumento($solicitud_documentos_id){
        $solicitud_documentos = DB::table('solicitud_documentos')
        ->select('solicitud_documentos.*')
        ->where('id', $solicitud_documentos_id)
        ->first();

        if(!empty($solicitud_documentos)){
            $file = env('APP_ADMISIONES').$solicitud_documentos->nombre;
            $tempImage = tempnam(sys_get_temp_dir(), $file);
            copy($file, $tempImage);
            return response()->download($tempImage,$solicitud_documentos->nombre);
        }

    }

    public function aprobarRechazar(Request $request)
    {
        $documento = SolicitudDocumento::find($request->solicitud_documento_id);
        $documento->estado = $request->estado;
        $documento->save();

        $result = $documento ? ['msg' => 'success', 'data' => 'Estado actualizado con éxito '] : ['msg' => 'error', 'data' => 'Ocurrio un error al actulizar el estado'];

        return response()->json($result);
    }

    public function pdf($id_solicitud, $cod_solicitud)
    {
        $postulante = DB::table('postulante')
        ->join('solicitud', 'solicitud.postulante_id', '=', 'postulante.id')
        ->join('postulante_carreras', 'postulante_carreras.postulante_id', '=', 'postulante.id')
        ->join('postulante_estudiantiles', 'postulante_estudiantiles.postulante_id', '=', 'postulante.id')
        ->join('postulante_familiares', 'postulante_familiares.postulante_id', '=', 'postulante.id')
        ->leftJoin('solicitud_documentos', 'solicitud_documentos.solicitud_id', '=', 'solicitud.id')
        ->select('solicitud.*',
                'postulante.*',
                'postulante_carreras.*',
                'postulante_familiares.celular as emergencia_celular',
                'postulante_familiares.*',
                'postulante_estudiantiles.*',
                'solicitud_documentos.nombre as documento_nombre')
        ->where('solicitud.id',$id_solicitud)
        ->where('solicitud_documentos.nombre', 'LIKE', '%FOTO%')
        ->first();
        $foto_path = env('APP_ADMISIONES');

        if($postulante != NULL){
            if($postulante->documento_nombre != NULL){
                $foto_name = $postulante->documento_nombre;
            }
            else{
                $foto_name = '';
            }
            $foto_url =  $foto_path.$foto_name;
            if($foto_name == NULL || $foto_name == ''){
                $foto_url = '';
            }
            if (!file_exists($foto_url)) {
                $foto_url = public_path() .'/images/default.png';
            }

            $pdf = PDF::loadView('solicitudes.pdf_template.generar_pdf', compact('postulante', 'foto_url'));
            return $pdf->stream('solicitud-admision.pdf');
        }
        else{
            $postulante = DB::table('postulante')
            ->join('solicitud', 'solicitud.postulante_id', '=', 'postulante.id')
            ->join('postulante_carreras', 'postulante_carreras.postulante_id', '=', 'postulante.id')
            ->join('postulante_estudiantiles', 'postulante_estudiantiles.postulante_id', '=', 'postulante.id')
            ->join('postulante_familiares', 'postulante_familiares.postulante_id', '=', 'postulante.id')
            ->select('solicitud.*',
                    'postulante.*',
                    'postulante_carreras.*',
                    'postulante_familiares.celular as emergencia_celular',
                    'postulante_familiares.*',
                    'postulante_estudiantiles.*')
            ->where('solicitud.id',$id_solicitud)
            ->first();
            $foto_url = public_path() .'/images/default.png';

            $pdf = PDF::loadView('solicitudes.pdf_template.generar_pdf', compact('postulante', 'foto_url'));
            return $pdf->stream('solicitud-admision.pdf');
        }
    }

    public function aplicarCambios(Request $request){
        //$solicitud =  Solicitud::with('postulante')->with('datos_adicional')->with('documentos')->find($request->id_solicitud);
        $solicitud =  Solicitud::with('postulante')->with('solicitud_estado')->with('documentos')->find($request->id_solicitud);
        $documentos = Documento::with('servicio')->with('tipo_documento')
        ->where('documentos.servicio_id',$solicitud->servicio_id)
        ->where('documentos.estado',"A")
        ->where('documentos.requerido', "S")
        ->get();
        $total_documentos = count($documentos);


        $documentos_aprobados = 0;
        foreach ($solicitud->documentos as $key => $documento) {
            if ($documento->estado == 'A') {
                $documentos_aprobados = $documentos_aprobados + 1;
            }
        }

        if ($documentos_aprobados >= $total_documentos) { //documentos aprobados es igual al total de documentos, Revisad0
            $id_estado = 3; #revisado  REVISAR ID DE PRODUCCION
        }else{ #menor igual pendiente solicitud
             $id_estado = 5; #pendiente  REVISAR ID DE PRODUCCION
        }
        //\Log::debug(json_encode($solicitud));
        $solictud = DB::table('solicitud')
            ->where('id', $request->id_solicitud)
            ->update(['estado_id' => $id_estado]);

        $estado = SolicitudEstado::find($id_estado);
        $motivo = $request->motivo;

        $objSolHistorial = new SolicitudHistorial();
        $objSolHistorial->solicitud_id = $request->id_solicitud;
        $objSolHistorial->estado_id =  $id_estado;
        $objSolHistorial->user_id =  Auth::user()->id;
        $objSolHistorial->fecha = date('Y-m-d h:i:s');
        $objSolHistorial->ip = $_SERVER['REMOTE_ADDR'];
        $objSolHistorial->observaciones = 'Se realizó el cambio de estado de solicitud desde la opción Aplicar cambios';
        $objSolHistorial->motivo = $motivo;
        $objSolHistorial->save();

        //if ($id_estado == 3) {
            Mail::to($solicitud->postulante->email)->send(new SendEstado($solicitud,$estado->nombre, $motivo));
        //}
        $resultAplicarCambios = $objSolHistorial ? ['msg' => 'success', 'data' => 'Se ha creado actualizado el estado de la solicitud '] : ['msg' => 'error', 'data' => 'Ocurrio un error al actulizar el estado la solicitud '];
        if($request->migrar == 'S'){
            if($migrarEstudiante = $this->migrar($request)){
            $result = $migrarEstudiante ? ['msg' => 'success', 'data' => 'Se ha migrado al estudiante correctamente'] : ['msg' => 'error', 'data' => 'Ocurrio un error al migrar al postulante '];
            }
            else{
                $result = $resultAplicarCambios;
            }
        }

        return response()->json($result);

    }

    public function migrar(Request $request){
        #id de solicitud para migrar debe estar id estado APROBADA
        $solicitud = Solicitud::with('postulante')->with('postulante.datos_familiares')->with('postulante.datos_estudiantiles')->with('postulante.datos_carrera')->find($request->id_solicitud);
        $documentos = SolicitudDocumento::with('documento')->where('solicitud_id',$solicitud->id)->get();

        $documento = '<documentos>';
        foreach ($documentos as $key => $value) {
            $ext = explode(".",$value->nombre)[1] ?? 'pdf';
            $documento .= "<documento abreviatura='".trim($value->documento->abreviatura)."' extension='".trim($ext)."' />";
        }
        $documento .= '</documentos>';
        if ($solicitud->estado_id == 3) { ##APROBADO
            $codigo_pemsun = '';
            //$cod_pens = 1; ## --> 1 para grado y 34 para posgrado
            $tipo_id = 'C'; ## --> 'C' Cedula o P' Pasaporte
            $cod_tip_alum = 1; ## --> REGULAR  1 para grado y 34 para posgrado
            $nomb1 = explode(" ",$solicitud->postulante->nombres)[0] ?? ' ' ;
            $nomb2 = explode(" ",$solicitud->postulante->nombres)[1] ?? explode(" ",$solicitud->postulante->nombres)[0] ;
            $apel1 = explode(" ",$solicitud->postulante->apellidos)[0]  ?? ' ' ;
            $apel2 = explode(" ",$solicitud->postulante->apellidos)[1]  ?? explode(" ",$solicitud->postulante->apellidos)[0] ;
            $fecha_nacimiento = \Carbon\Carbon::parse($solicitud->postulante->fecha_nacimiento)->format('d/m/Y');
            $result = Helper::migrarAlumno($solicitud->postulante->datos_carrera->facultad_id,
                $solicitud->postulante->datos_carrera->carrera_id,
                $solicitud->postulante->datos_carrera->enfasis_id,
                null,
                $cod_tip_alum,
                $solicitud->postulante->documento,
                $tipo_id,

                $solicitud->postulante->sexo,$nomb1,$nomb2,$apel1,$apel2,$fecha_nacimiento,
                $solicitud->postulante->direccion,$solicitud->postulante->telefono,$solicitud->postulante->celular,$solicitud->postulante->estado_civil,$solicitud->postulante->email,'','','','',$solicitud->postulante->provincia,'',Auth::user()->name,$solicitud->postulante->datos_estudiantiles->institucion_id,$documento);
            $rspta = $result;
            //$rspta[0]->cod_alum .' ass';
            \Log::debug(json_encode($rspta));
            if (isset($rspta[0]['cod_alum'])) { ## existe codigo de alumno
                $codigo_alumno = $rspta[0]['cod_alum'];
                $pass = $rspta[0]['pass'];
                $username = $rspta[0]['username'];

                $postulant = Postulante::find($solicitud->postulante->id);
                $postulant->codigo_alumno = $codigo_alumno;
                $postulant->save();

                \Log::debug("---- CODIGO ---- ".$codigo_alumno);
                /* CORREO ENVIADO A ESTUDIANTE Y ASESOR*/
                Mail::to($solicitud->postulante->email)
                ->bcc(env('MAIL_TO_ALERT_PROCESS'))
                ->send(new SendCredencialAtrium($codigo_alumno,$username,$pass,$solicitud));

                //enviar el correo para la migracion de alumno
                // return response()->json(['msg' => 'success', 'data' => 'Alumno migrado al sistema Atrium exitosamente']);
                return true;
            }else{
                // return response()->json(['msg' => 'error', 'data' => 'ocurrio un error al migrar el estudiante' ]);
                return false;
            }
        }else{
            return response()->json(['msg' => 'error', 'data' => 'La solicitud del postulante no se encuentra en estado aprobada']);
        }
    }
}
