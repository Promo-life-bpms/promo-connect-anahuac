<?php

namespace App\Http\Livewire;

use App\Models\MessageSoporte;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class SoporteSellerComponent extends Component
{
    public $users, $message, $usersWithMessage, $usersWithoutMessage, $userMessages, $filteredUser;
    public $userSelected, $messages;
    public $search = '';
    protected $listeners = ['echo:real-time,ChatEvent' => 'updateMessages'];

    public function render()
    {
        $this->users = User::join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', 'roles.id')
            ->whereIn('roles.name', ['buyer', 'buyers-manager'])
            ->select('users.*')
            ->get();

   
        $sellerID = auth()->user()->id; 
      
        $filteredUser = $this->users->filter(function ($user) {
            return str_contains(strtolower($user->name), strtolower($this->search));
        });
      
        $this->users = $filteredUser;
        
        $lastUsersWithMessage = MessageSoporte::whereIn('id', function ($query) use ($sellerID) {
            $query->selectRaw('MAX(id)')
                ->from('message_soportes')
                ->where('soporte_id', $sellerID)
                ->groupBy('client_id')
                ->orderBy('created_at', 'asc');
            })->get();
        
        $usersWithMessagesData = [];

        foreach($this->users as $user){
            foreach($lastUsersWithMessage as $userMessage){
                if($userMessage->client_id ==  $user->id){
                    array_push($usersWithMessagesData, $user);
                   
                }
            }
        }
       
        $this->userMessages = $lastUsersWithMessage != null? $lastUsersWithMessage->reverse(): [];

        $this->usersWithMessage = $usersWithMessagesData != null?$usersWithMessagesData : [];

        $this->usersWithoutMessage = $usersWithMessagesData != null? $this->users->diff( $usersWithMessagesData): $this->users;
       
        $this->messages = $this->userSelected
            ? MessageSoporte::where('client_id', $this->userSelected->id)->orderBy('created_at', 'ASC')->get()
            : null;
        return view('pages.seller.components.soporte-seller-component');
    }

    public function seccionarChat($id)
    {
        $now = Carbon::now();
        $formattedDate = $now->format('Y-m-d H:i:s');
        $this->userSelected = User::find($id);
        //Actualiza valores nulos
        MessageSoporte::where('client_id', $this->userSelected->id)
            ->whereNull('soporte_id')
            ->update([
                'soporte_id' => auth()->user()->id,
                'receiver_id' => auth()->user()->id,
             
            ]);
        $this->emit('unreadMessages');
        //Actualiza los mensajes no leidos
        MessageSoporte::where('client_id', $this->userSelected->id)->where('is_read',0)->update([
            'is_read' => 1,
            'updated_at'=> $formattedDate
        ]);
        

        $this->dispatchBrowserEvent('downScroll');
    }

    public function sendMessage()
    {
        /* $this->validate([
            'message' => "required"
        ]); */
        // Obtener el usuario que esta atendiendo el chat
        auth()->user()->message()->create([
            'message' => json_encode(['type' => 'text', 'data' => $this->message]),
            'receiver_id' => $this->userSelected->id,
            'soporte_id' => auth()->user()->id,
            'client_id' => $this->userSelected->id,
            'is_read' => 1
        ]);

        $this->message = null;
    }

    public function updateMessages()
    {
        $this->messages = $this->userSelected
        ? MessageSoporte::where('client_id', $this->userSelected->id)->orderBy('created_at', 'ASC')->get()
        : null;
    }
}
