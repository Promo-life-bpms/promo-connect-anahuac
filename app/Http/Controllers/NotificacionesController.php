<?php

namespace App\Http\Controllers;

use App\Models\Muestra;
use Illuminate\Http\Request;

class NotificacionesController extends Controller
{
    public function eliminar_notificaciones()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function cerrar_notificacion($notificacion_id)
    {
        auth()->user()->unreadNotifications->when($notificacion_id, function ($query) use ($notificacion_id) {
            return $query->where('id', $notificacion_id);
        })->markAsRead();
        return redirect()->back();
    }
}
