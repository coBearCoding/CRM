<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Campana;
use App\PermisosNPrimario;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $userInfo = \Session::get('infoUser');
        Carbon::setLocale(config('app.locale'));

        //$campanasAll = [];
       
        if (!empty($userInfo->sede_id)) {
            $campanasAll = Campana::where('estado','A')->where('sede_id',$userInfo->sede_id)->get();
        }else{
            $campanasAll = Campana::where('estado','A')->get();
        }

        $ofertaAcademicaAll = [];
        if (!empty($userInfo->user_id)) {
            $ofertaAcademicaAll = PermisosNPrimario::with('nprimario')->where('user_id',$userInfo->user_id)->get();
        }

        /*$baseUrl = $userInfo->empresa->url_socket;

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
            'trama_login_ws'=>'{"agentnumber" : "'.$this->objinfoUser->extension.'","agentpassword" : "'.$this->objinfoUser->extension.'","agentname" :"SIP/'.$this->objinfoUser->extension.'","extension" :"'.$this->objinfoUser->extension.'"}'
        ];

        $response  = $client->request('POST','/modules/redlinks_ws/RestControllerWS.php/agentlogin',[
            'form_params' => $form_params
        ]);*/

        //View::share('campanasAll', $campanasAll);
        //View::share('ofertaAcademicaAll', $ofertaAcademicaAll);

        view()->composer('*', function ($view) 
        {
            $view->with('userInfo', \Session::get('infoUser') );    
        }); 
    }
}
