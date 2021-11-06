<?php

namespace App\Mail;

use App\CampanasUsers;
use App\Formulario;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;

class PlantillaFormulario extends Mailable
{
    use Queueable, SerializesModels; 

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public $title;
    public $template;

    public function __construct($data, $title, $template, $form, $lead, $imagen, $user, $archivo,$opcion)
    {
        $this->data = $data;
        $this->title = $title;
        $this->template = $template;
        $this->form_id = $form;
        $this->nom_lead = $lead;
        $this->imagen_carrera = $imagen;
        $this->user = $user;
        $this->archivo = $archivo;
        $this->opcion = $opcion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $asesor =  $this->user;

       // if (!empty($asesor)) {
            $nombre_lead = $this->nom_lead;
            $imagen_carrera = $this->imagen_carrera;
            $archivo =$this->archivo;
            $opcion =$this->opcion;
           /* var_dump( $nombre_lead);
            var_dump( $imagen_carrera);
            var_dump( $archivo); exit;*/
            if($opcion=='I'){
                $message = $this->subject($this->title)->view('mailing.plantilla', compact('asesor', 'nombre_lead', 'imagen_carrera'));
            }
            if($opcion=='C'){
                $message = $this->subject($this->title)->view('mailing.plantilaCont', compact('template'));
            }
            
            if(!empty($archivo)){
             // var_dump($archivo[0]); exit;
              for($i=0; $i<count($archivo); $i++){
                $path= public_path().'/files/'.$archivo[$i]->resp_auto_id.'/'.$archivo[$i]->nombre; 
                $message->attach($path);
              }
             /* foreach ($archivo as $row) { 

                $path= public_path().'/files/'.$row->resp_auto_id.'/'.$row->nombre; 
                $message->attach($path);
              }*/
            }

      //  }
//var_dump('resp'.$message); 
        $count = 0;
        /*foreach ($this->pdf as $key => $file) { 
            $count = $key+1;
            //$location = storage_path("app/public/4/LofqmFXsxxeAvJEZQpRluDzCJD6GzmPf5I747gpi.pdf");
             $message->attach(storage_path("app/public/".Str::replaceArray('/storage',[''],$file->archivo)), [
                    'as' => 'Archivo N°'.$count .'.pdf',
                    'mime' => 'application/pdf',
                ]);
        }*/

       // return $message;
    }
}
 