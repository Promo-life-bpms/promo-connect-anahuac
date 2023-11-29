<?php

namespace App\Http\Livewire;

use App\Models\Quote;
use Livewire\Component;

class AllQuotesComponent extends Component
{
    public $search;
    public function regresarPaginaAnterior()
    {
        return redirect()->route('administrador');
    }
    public function render()
    {
        $usercompras = Quote::join('users', 'users.id', 'quotes.user_id')
            ->join('quote_updates', 'quote_updates.quote_id', 'quotes.id')
            ->join('quote_products', 'quote_products.id', 'quote_updates.quote_id')
            ->where("quotes.id",  "LIKE", "%" . trim($this->search) . "%")
            ->orWhere("users.name", "LIKE", "%" . trim($this->search) . "%")
            ->get();
        return view('livewire.all-quotes-component', ['compras' => $usercompras]);
    }
    // use WithPagination;
    // public $selected_id, $keyWord, $user_id, $name, $contact, $email, $phone;
    // public function render()
    // {
    //     \DB::statement("SET SQL_MODE=''");
    //     // `quote_information` ON `quote_information`.`id`=`quote_updates`.`quote_information_id` GROUP BY `quote_updates`.`quote_id` ORDER BY `quote_information`.`created_at` ASC;
    //     $quotes = Quote::join('quote_updates', 'quote_updates.quote_id', 'quotes.id')
    //         ->join('quote_information', 'quote_updates.quote_information_id', 'quote_information.id')
    //         ->join('users', 'users.id', 'quotes.user_id')
    //         ->where(function ($query) {
    //             $query->orWhere("quote_information.name", "LIKE", '%' . $this->keyWord . '%')
    //                 ->orWhere("quote_information.oportunity", "LIKE", '%' . $this->keyWord  . '%')
    //                 ->orWhere("quotes.id", "LIKE", '%' . str_replace('QS', '', str_replace('qs', '', $this->keyWord)) . '%')
    //                 ->orWhere("quotes.lead", "LIKE", '%' . $this->keyWord . '%')
    //                 ->orWhere("users.name", "LIKE", '%' . $this->keyWord . '%');
    //         })->select('quotes.*')
    //         ->groupBy('quotes.id')
    //         ->orderBy('quote_information.created_at', 'DESC')
    //         ->simplePaginate(30);
    //     return view('livewire.all-quotes-component', ['quotes' => $quotes]);
    // }
}
