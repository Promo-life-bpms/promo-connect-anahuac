<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CountCartQuote extends Component
{
    public $total = 0;


    protected $listeners = ['currentQuoteAdded'];

    public function currentQuoteAdded()
    {
        if (auth()->user()->currentQuote) {
            $this->total = count(auth()->user()->currentQuote->currentQuoteDetails);
        } else {
            $this->total;
        }
    }

    public function mount()
    {
        if (auth()->user()->currentQuote) {
            $this->total = count(auth()->user()->currentQuote->currentQuoteDetails);
        }
    }
    public function render()
    {
        return view('livewire.count-cart-quote');
    }
}
