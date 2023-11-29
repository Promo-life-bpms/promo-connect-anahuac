<?php

namespace App\Http\Livewire;

use App\Models\MessageSoporte;
use Livewire\Component;

class CountMessagesSupport extends Component
{
    public $total = 0;
    protected $listeners = ['unreadMessages'];

    public function unreadMessages()
    {

       $this->total = MessageSoporte::where('is_read', 0)->count();
    }

    public function mount()
    {
        $this->total = MessageSoporte::where('is_read', 0)->count();
    }

    public function render()
    {
        return view('livewire.count-messages-support');
    }
}
