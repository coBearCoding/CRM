<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCredencialAtrium extends Mailable
{
    use Queueable, SerializesModels;

    public $codigo;
    public $usuario;
    public $password;
    public $solicitud;

    public function __construct($codigo,$usuario,$password,$solicitud)
    {
        $this->codigo = $codigo;
        $this->usuario = $usuario;
        $this->password = $password;
        $this->solicitud = $solicitud;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $codigo = $this->codigo;
        $usuario = $this->usuario;
        $password = $this->password;
        $solicitud = $this->solicitud;

        return $this->subject('Universidad Ecotec | Admisiones')->view('MailingMasivo.alumno', compact('codigo','usuario','password','solicitud'));
    }
}
