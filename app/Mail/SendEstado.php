<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEstado extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitud = null;
    public $estado = null;
    public $motivo = null;

    public function __construct($solicitud,$estado, $motivo)
    {
        $this->solicitud = $solicitud;
        $this->estado = $estado;
        $this->motivo = $motivo;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $solicitud = $this->solicitud;
        $estado = $this->estado;
        $motivo = $this->motivo;

        return $this->subject('Universidad Ecotec | Admisiones')->view('MailingMasivo.email', compact(
            'solicitud',
            'estado',
            'motivo'));
    }
}
