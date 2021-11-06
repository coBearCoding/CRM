<?php

namespace App\Http\Controllers;

use App\Empresa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EmpresaController extends Controller
{

    public function __construct()
    {
        $this->middleware('configure');
    }

    public function index()
    {
        $infoUser = session('infoUser');
        $info = Empresa::where('id', $infoUser->empresa_id)->where('estado', 'A')->first();
        return view('empresa.index', compact('info', $info));
    }

    public function save(Request $request)
    {

        try {
            $entidad = Empresa::find($request->hide_id);

            if (!empty($entidad)) {

                $entidad->nombre = $request->txt_nombre;
                $entidad->ruc = $request->txt_ruc;
                $entidad->telefonos = $request->txt_telf;
                $entidad->direccion = $request->txt_direccion;
                $entidad->email = $request->txt_email;
                //$entidad->url_sitio = $request->url_sitio;
                $entidad->carpeta = $request->txt_carpeta;
                //$entidad->ruta_logo = $request->ruta_logo;
                //$entidad->color_header = $request->color_header;
                //$entidad->color_banner = $request->color_banner;
                $entidad->host_email = $request->txt_user_mail;
                $entidad->puerto_email = $request->txt_port_mail;
                $entidad->smtp_email = $request->txt_smtp_mail;
                $entidad->user_email = $request->txt_user_mail;
                $entidad->pass_email = $request->txt_pass_mail;
                $entidad->nombre_envio = $request->txt_nombre_envio;

                $entidad->url_socket = $request->txt_url_socket;
                $entidad->token_socket = $request->txt_tok_socket;
                $entidad->estado_socket = $request->estado_socket;

                $entidad->save();

                return  ['msg' => 'success', 'data' => 'Se ha actualizado la informacion de la empresa.'];

            }

        } catch (Exception $e) {
            return ['msg' => 'error', 'data' => $e->getMessage()];
        }

    }

}
