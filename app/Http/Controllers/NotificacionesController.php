<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificacionesController extends Controller
{
    public function read(Request $request)
    {
    	DatabaseNotification::find($request->id)->markAsRead(); ##notificacion marcada como leida
    }

    public function index(Request $request)
    {
    	return Auth::user()->unreadNotifications; ##notificacion marcada como leida
    }
}
