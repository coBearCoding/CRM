<?php

namespace App\Listeners;

use App\Events\CrmEvents;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\User;
use App\Notifications\ContactoNotificacion;

class CrmListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CrmEvents  $event
     * @return void
     */
    public function handle(CrmEvents $event)
    {
        $user = User::find($event->data->contacto_historico_last->vendedor_id);
        if (!empty($user)) {
            Notification::send($user, new ContactoNotificacion($event->data));## como primera instancia recibe el meodelo del usuario que va a notificar;
        }
    }
}
