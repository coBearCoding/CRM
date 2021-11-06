<?php

namespace App\Http\Controllers;

use App\ContactoGeneral;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MailingImport;
use Illuminate\Support\Facades\DB;
use App\Mail\SendTransaccional;
use Illuminate\Support\Facades\Mail;

class MailingController extends Controller
{
    public $plantillas;

    public function __construct() {
        $this->middleware(function ($request, $next){
            $this->plantillas = Helper::getTemplates();
            return $next($request);
        });
    }
    
    public function index(){
        $templates = $this->plantillas;
        return view('MailingMasivo.index',compact('templates'));
    }

    public function template(Request $request){
        $html = '';
        foreach($this->plantillas['templates'] as $template){
            if($template['id'] ==  $request->templateid){
                $html = $template['htmlContent'];
                break;
            }
        }
        return $html;
    }

    public function sendMailing(Request $request){
        //return $request;
        try {
            DB::beginTransaction();
            $file =  $request->file('archivo');
            if (empty($file)) {
                return back()->with('error', 'El archivo es obligatorio');
            }
            if (empty($request->templateid)) {
                return back()->with('error', 'La plantilla es obligatorio');
            }
	        Excel::import(new MailingImport, $file);

            $datos = ContactoGeneral::where('estado_correo','P')->get();

            if ($request->envio =='1') { ##TRANSACCIONAL
                $html = $this->template($request);
                $senderMail = env('MAIL_SENDINBLU');
                $toMails = [];
                foreach ($datos as $key => $value) {
                    $toMails[] = $value['email'];
                }
                Mail::to($senderMail)->bcc($toMails)->send(new SendTransaccional($html,$request->asunto));
                ContactoGeneral::where('estado_correo', 'P')->update(['estado_correo' => 'E']);
            }

            if ($request->envio =='2') { ##SENDINBLU
                $toMails = [];
                foreach ($datos as $key => $value) {
                    $toMails[] = ['email'=>$value['email'],'name'=>$value['nombres']];
                }

                Helper::postSendMailMasivo($toMails,$request->templateid,$request->asunto);
                ContactoGeneral::where('estado_correo', 'P')->update(['estado_correo' => 'E']);

            }
            DB::commit();
	        return back()->with('message', 'Envio de Correo realizada con éxito');
        } catch (Exception $e) {
            DB::rollBack();
        	return back()->with('error', 'Ocurrio un error al realizar la importación '.$e->getMessage());
        }
    }

    public function htmlView($templateId){

        $html = '';
        foreach($this->plantillas['templates'] as $template){
            if($template['id'] ==  $templateId){
                $html = $template['htmlContent'];
                break;
            }
        }
        return view('leads.ver',compact('html'));
    }

}
