<?php

namespace App\Mail;

use App\CampanasUsers;
use App\Formulario;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;

class PlantillaGeneral extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $title;

    public function __construct($title)
    {

        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $this->subject($this->title)->view('emails.jacademica');

    }
}
 