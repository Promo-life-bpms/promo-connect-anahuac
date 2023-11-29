<?php

namespace App\Http\Livewire;

use App\Models\MessageSoporte;
use App\Models\User;
use Livewire\Component;

class SoporteComponent extends Component
{
    public $message, $messages, $receiver_id;

    protected $listeners = ['echo:real-time,ChatEvent' => 'updateMessages'];


    public function render()
    {
        $this->messages = MessageSoporte::where('emisor_id', auth()->user()->id)->orWhere('receiver_id', auth()->user()->id)->get();
        return view('livewire.soporte-component');
    }

    public function sendMessage()
    {
        if ($this->message === null || trim($this->message) === "") {
            return;
        }
        $seller = User::join('role_user', 'role_user.user_id', 'users.id')
        ->where("role_user.role_id", 2)->get()->first();
        
        $supportID = null;

        $messageExist = MessageSoporte::where('client_id', auth()->user()->id)->get()->last();

        if($messageExist == null ||$messageExist ==[] ){
            $seller = User::join('role_user', 'role_user.user_id', 'users.id')
            ->where("role_user.role_id", 2)->get()->first();
         
            $supportID = $seller->id;
        }else{
            $supportID = $messageExist->soporte_id; 
        }

        $newMessage =    auth()->user()->message()->create([
            'message' => json_encode(['type' => 'text', 'data' => $this->message]),
            'receiver_id' =>  $supportID,
            'soporte_id' =>  $supportID,
            'client_id' => auth()->user()->id,
            'is_read' => 0
        ]);

        event(new \App\Events\ChatEvent($newMessage, $newMessage->message));

        $this->message = null;

        $this->dispatchBrowserEvent('downScroll');
    }

    public function updateMessages()
    {
        $this->messages = MessageSoporte::where('emisor_id', auth()->user()->id)->orWhere('receiver_id', auth()->user()->id)->get();
    }
}
