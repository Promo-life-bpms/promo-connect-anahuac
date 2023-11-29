<?php

namespace App\Listeners;

use App\Models\Muestra;
use App\Models\User;
use App\Notifications\MuestraStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class MuestraStatusListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // $muestras = Muestra::where('id', $event->muestra->id)
        //     ->get();
        // dd($muestras);
        User::where('id', $event->muestra->user_id)
            // ->except($product->user_id)
            ->each(function (User $user) use ($event) {
                Notification::send($user, new MuestraStatusNotification($event->muestra));
                // $user->notify(new MuestraStatusNotification($event));
            });
    }
}
