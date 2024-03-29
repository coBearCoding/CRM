<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use App\Parametro;
use App\Periodo;
use App\Profile;
use App\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function authenticated(Request $request, $user)
    {

        // INICIALIZA EL PERIODO ACTUAL
        $anio = date('Y');
        $periodoActual = Periodo::where('anio', $anio)->first();

        $nameNivel1 = Parametro::where('id', 1)->first();
        $nameNivel2 = Parametro::where('id', 2)->first();
        $permiso_np = [];
        //INICIALIZA MENU CON PERMISOS
        $lstMenu = DB::select("exec sp_rol_permisos_all ?", array(Auth::user()->rol_id));
        $lstSede = Sede::where('estado', 'A')->get();

        $objUsuario = Profile::with('empresa')->with('sede')->with('user')->with('user.permiso_np')->where('user_id', Auth::user()->id)->first();

        foreach($objUsuario->user->permiso_np as $obj){
            $permiso_np[] = $obj['nprimario_id'];
        }

        Session::put('periodo', $periodoActual->id);
        Session::put('nivel1', $nameNivel1->valor);
        Session::put('nivel2', $nameNivel2->valor);
        Session::put('menu', $lstMenu);
        Session::put('infoUser', $objUsuario);
        Session::put('permiso_np', $permiso_np);
        Session::put('lstSede', $lstSede);
        Session::put('login', 'activo');
        Session::save();

        //DEFINE INFORMACIÓN DEL USUARIO


        //PARAMETROS

        //LOGIN EN DINOMI
        /*if (!empty($objUsuario->extension)) {
            try {
                $baseUrl = env('API_ENDPOINT');

                $headers = [
                    'Accept' => 'application/json',
                   "Content-Type", "application/x-www-form-urlencoded"
                ];

                $client = new Client([
                    'base_uri' => $baseUrl,
                    'headers' => $headers,
                    'verify' => false
                ]);

                $form_params = [
                    'trama_login_ws'=>'{"agentnumber" : "'.$objUsuario->extension.'","agentpassword" : "'.$objUsuario->extension.'","agentname" :"SIP/'.$objUsuario->extension.'","extension" :"'.$objUsuario->extension.'"}'
                ];

                $response  = $client->request('POST','/modules/redlinks_ws/RestControllerWS.php/agentlogin',[
                    'form_params' => $form_params
                ]);

                //$response = json_decode($response->getBody(), true);

            } catch (\GuzzleHttp\Exception\ConnectException $e) {
                return response()->json(['msg' => 'error', 'data' => 'No se puede conectar al servidor de elastix. '.$e->getMessage() ]);
            }
        }*/
        //LOGIN EN DINOMI


    }
}
