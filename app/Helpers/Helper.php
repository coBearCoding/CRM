<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
class Helper {

	#enviar mail
    public static function postSendMail($toName,$toMail,$templadeid,$vendedor,$subject,$telfVendedor,$emailVendedor) {

        try{
            $endpoint = env('API_ENDPOINT_SENDINBLU');
            $apikey = env('API_KEY_SENDINBLU');
            $senderMail = env('MAIL_SENDINBLU');
            $senderName = env('NAME_SENDINBLU');

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json' ,
                'api-key' => $apikey
             ];

            $client = new Client([
                'base_uri' => $endpoint,
                'headers' => $headers
            ]);

            $sender = ['name'=>$senderName,'email'=>$senderMail];

            //$to = array();
            $to[] = ['email'=>$toMail,'name'=>$toName];
            $cc[] = ['email'=>$emailVendedor,'name'=>$vendedor];

            $params = ['NOMBRE'=>$toName,'ASESOR'=>$vendedor,'TELEFONO_ASESOR'=>$telfVendedor,'EMAIL_ASESOR'=>$emailVendedor];

            $body = [
                //'sender'=> $sender,
                'to' => $to,
                'cc' => $cc,
                'subject' => $subject,
                'templateId' => (int)$templadeid,
                'params' => $params
            ];
            //return  json_encode($body);
            $response  = $client->request('POST','/v3/smtp/email',[
                'body' => json_encode($body)
            ]);

            return json_decode($response->getBody(), true);

        }catch (\GuzzleHttp\Exception\ConnectException $e) {
            return response()->json(['msg' => 'error', 'data' => 'No se puede conectar al servidor de SendinBlue. '.$e->getMessage() ]);
        }
    }

    public static function postSendMailMasivo($ToArrayMails,$templadeid,$subject) {

        try{
            $endpoint = env('API_ENDPOINT_SENDINBLU');
            $apikey = env('API_KEY_SENDINBLU');
            $senderMail = env('MAIL_SENDINBLU');
            $senderName = env('NAME_SENDINBLU');

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json' ,
                'api-key' => $apikey
             ];

            $client = new Client([
                'base_uri' => $endpoint,
                'headers' => $headers
            ]);

            $sender = ['name'=>$senderName,'email'=>$senderMail];

            //$to = array();
            //$to[] = ['email'=>$toMail,'name'=>$toName];


            $body = [
                //'sender'=> $sender,
                'to' => $ToArrayMails,
                'subject' => $subject,
                'templateId' => (int)$templadeid
            ];

            $response  = $client->request('POST','/v3/smtp/email',[
                'body' => json_encode($body)
            ]);

            return json_decode($response->getBody(), true);

        }catch (\GuzzleHttp\Exception\ConnectException $e) {
            return response()->json(['msg' => 'error', 'data' => 'No se puede conectar al servidor de SendinBlue. '.$e->getMessage() ]);
        }
    }

    public static function getContacts() {

        try{
            $endpoint = env('API_ENDPOINT_SENDINBLU');
            $apikey = env('API_KEY_SENDINBLU');
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json' ,
                'api-key' => $apikey
             ];

            $client = new Client([
                'base_uri' => $endpoint,
                'headers' => $headers
            ]);

            $response  = $client->request('GET','/v3/contacts');

            return json_decode($response->getBody(), true);

        }catch (\GuzzleHttp\Exception\ConnectException $e) {
            return response()->json(['msg' => 'error', 'data' => 'No se puede conectar al servidor de SendinBlue. '.$e->getMessage() ]);
        }
    }

    public static function getTemplates() {

        try{
            $endpoint = env('API_ENDPOINT_SENDINBLU');
            $apikey = env('API_KEY_SENDINBLU');
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json' ,
                'api-key' => $apikey
             ];

            $client = new Client([
                'base_uri' => $endpoint,
                'headers' => $headers
            ]);

            $response  = $client->request('GET','/v3/smtp/templates');

            return json_decode($response->getBody(), true);

            return ['templates'=>[]];
        }catch (\GuzzleHttp\Exception\ConnectException $e) {
            return response()->json(['msg' => 'error', 'data' => 'No se puede conectar al servidor de SendinBlue. '.$e->getMessage() ]);
        }
    }

    public static function postContact() {

        try{
            $endpoint = env('API_ENDPOINT_SENDINBLU');
            $apikey = env('API_KEY_SENDINBLU');
            $headers = [
               'Content-Type' => 'application/json',
               'Accept' => 'application/json' ,
               'api-key' => $apikey
            ];

            $client = new Client([
                'base_uri' => $endpoint,
                'headers' => $headers
            ]);

            $body =[
                'email'=>"egordilloa@redlinks.com.ec",
                'attributes'=>[
                    'NOMBRE'=>'Erick Gordillo Ayala'
                ]
            ];

            $response  = $client->request('POST','/v3/contacts',[
                'body' => json_encode($body)
            ]);

            return json_decode($response->getBody(), true);

        }catch (\GuzzleHttp\Exception\ConnectException $e) {
            return response()->json(['msg' => 'error', 'data' => 'No se puede conectar al servidor de SendinBlue. '.$e->getMessage() ]);
        }
    }

    public static function searchArray($array, $valor){
        $dato ="";
        foreach ($array as $key => $value) {
            if ($value['documento_id'] == $valor) {
                $dato = $value;
                break;
            }
        }
        return $dato;
    }

    public static function migrarAlumno($cod_facu,$cod_carr,$cod_enfa,$cod_pens,$cod_tip_alum,$ced_alum,$tipo_id,$sexo,$nomb1,$nomb2,$apel1,$apel2,$fec_naci,$domicilio,$telefono,$celular,$estado_civil,$e_mail,$e_mail2,$religion,$lug_nacer,$nacional,$provincia,$pais,$usuario,$id_establecimiento,$documento){


        try{
            $endpoint = 'http://api.ecotec.edu.ec';
            $apikey = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vYXBpLmVjb3RlYy5lZHUuZWMvYXBpL3VzZXIvcmVnaXN0ZXIiLCJpYXQiOjE2MDU4MjI4MzksImV4cCI6MTkyMTE4MjgzOSwibmJmIjoxNjA1ODIyODM5LCJqdGkiOiJJRjdoWXoyaGxQb2JPN2VVIiwic3ViIjoxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.bPgD5kPtUDdOy4AYIMOEqFzGrqswOQ7yd_sKooP_B6k';
            $headers = [
               'Content-Type' => 'application/json',
               'Accept' => 'application/json' ,
               'Authorization' => 'Bearer '.$apikey
            ];

            $client = new Client([
                'base_uri' => $endpoint,
                'headers' => $headers
            ]);

            $body = [
                'cod_facu'=>$cod_facu,
                'cod_carr'=>$cod_carr,
                'cod_enfa'=>$cod_enfa,
                'cod_pens'=>$cod_pens,
                'cod_tip_alum'=>$cod_tip_alum,
                'ced_alum'=>$ced_alum,
                'tipo_id'=>$tipo_id,
                'sexo'=>$sexo,
                'nomb1'=>$nomb1,
                'nomb2'=>$nomb2,
                'apel1'=>$apel1,
                'apel2'=>$apel2,
                'fec_naci'=>$fec_naci,
                'domicilio'=>$domicilio,
                'telefono'=>$telefono,
                'celular'=>$celular,
                'estado_civil'=>$estado_civil,
                'e_mail'=>$e_mail,
                'e_mail2'=>$e_mail2,
                'religion'=>$religion,
                'lug_nacer'=>$lug_nacer,
                'nacional'=>$nacional,
                'provincia'=>$provincia,
                'pais'=>$pais,
                'usuario'=>$usuario,
                'id_establecimiento'=>$id_establecimiento,
                'documentos' => $documento
            ];
            //return json_encode($body);
            $response  = $client->request('POST','/api/admisiones/guardarAlumno',[
                'body' => json_encode($body)
            ]);

            return json_decode($response->getBody(), true);

        }catch (\GuzzleHttp\Exception\ConnectException $e) {
            return response()->json(['msg' => 'error', 'data' => 'No se puede conectar al servidor de SendinBlue. '.$e->getMessage() ]);
        }
    }

    public static function phone($number){
        return Str::substr($number, -9);
    }

    public static function sumArray($array, $valor){
        $total = 0;
        foreach ($array as $key => $value) {
            /* if ($value[$valor] == $valor) {
                $dato = $value;
                break;
            } */
            $total = $total + $value->{"$valor"};
        }
        return $total;
    }

    public static function sumSeguimiento($array, $valor){
        $total = 0;
        foreach ($array as $key => $value) {
            /* if ($value[$valor] == $valor) {
                $dato = $value;
                break;
            } */
            $total = $total + $value->{"$valor"};
        }
        return $total;
    }

    public static function obtenerMes($valor){
        $mes = "";
        switch ($valor) {
            case "01": $mes="Enero";
		        break;
            case "2": $mes="Febrero";
                break;
            case "3": $mes="Marzo";
                break;
            case "4": $mes="Abril";
                break;
            case "5": $mes="Mayo";
                break;
            case "6": $mes="Junio";
                break;
            case "7": $mes="Julio";
                break;
            case "8": $mes="Agosto";
                break;
            case "9": $mes="Septiembre";
                break;
            case "10": $mes="Octubre";
                break;
            case "11": $mes="Noviembre";
                break;
            case "12": $mes="Diciembre";
                break;
        }
        return $mes;
    }




}
