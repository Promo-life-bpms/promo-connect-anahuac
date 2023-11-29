<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Client;

class ListQuotesComponent extends Component
{
    use WithPagination;

    public $selected_id, $keyWord, $user_id, $name, $contact, $email, $phone;

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        \DB::statement("SET SQL_MODE=''");
        // `quote_information` ON `quote_information`.`id`=`quote_updates`.`quote_information_id` GROUP BY `quote_updates`.`quote_id` ORDER BY `quote_information`.`created_at` ASC;
        $quotes = auth()->user()->quotes()
            ->join('quote_updates', 'quote_updates.quote_id', 'quotes.id')
            ->join('quote_information', 'quote_updates.quote_information_id', 'quote_information.id')
            ->where("quotes.user_id", auth()->user()->id)
            ->where(function ($query) {
                $query->orWhere("quote_information.name", "LIKE", '%' . $this->keyWord . '%')
                    ->orWhere("quote_information.oportunity", "LIKE", '%' . $this->keyWord  . '%')
                    ->orWhere("quotes.id", "LIKE", '%' . str_replace('QS', '', str_replace('qs', '', $this->keyWord)) . '%');
            })->select('quotes.*')
            ->groupBy('quotes.id')
            ->orderBy('quote_information.created_at', 'DESC')
            ->simplePaginate(30);
        return view('livewire.list-quotes-component', ['quotes' => $quotes]);
    }
}
