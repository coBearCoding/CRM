<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTransaccional extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public $data;
    public $title;
    public $texto;
    public $nombre_lead;

    /*public function __construct($data,$title,$texto,$nombre_lead)
    {
        $this->data = $data;
        $this->title = $title;
        $this->texto = $texto;
        $this->nombre_lead = $nombre_lead;
    }*/

    public function __construct($texto,$title)
    {
        $this->texto = $texto;
        $this->title = $title;
    }

    public function build()
    {
        $message = $this->subject($this->title)->view('emails.masivo',compact('texto'));
        
        $count  = 0;
        /*foreach ($this->pdf as $key => $file) { 
            $count = $key+1;
            //$location = storage_path("app/public/4/LofqmFXsxxeAvJEZQpRluDzCJD6GzmPf5I747gpi.pdf");
             $message->attach(storage_path("app/public/".Str::replaceArray('/storage',[''],$file->archivo)), [
                    'as' => 'Archivo N°'.$count .'.pdf',
                    'mime' => 'application/pdf',
                ]);
        }*/

        return $message;
    }
}
