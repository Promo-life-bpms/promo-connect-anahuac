<?php

namespace App\Http\Livewire;

use App\Models\Quote;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class DashboardComponent extends Component
{
    public $start, $end;
    public $dataQuoteCompany, $dataUserInfoTickets, $dataUserMountTickets, $dates;

    public function mount()
    {
        $this->end = Carbon::now()->format("Y-m-d");
        $this->start = Carbon::now()->subDays(5)->format("Y-m-d");
    }

    public function render()
    {
        $start = date($this->start);
        $end = date($this->end);
        $this->dates = [$start, $end];
        $pl = 0;
        $bh = 0;
        $pz = 0;
        $this->dataQuoteCompany  = [$pl, $pz, $bh];

        // Vendedores
        $dataUserCreatedLeads = [];
        $dataUserCountLeads = [];
        $dataUserWithoutLeads = [];
        $users = User::all();
        foreach ($users as $userCount) {
            $leadsCreated = $userCount->quotes()
                ->when($start !== '' || $end !== '', function ($query, $dates) {
                    if ($this->dates[0] == '')
                        $this->dates[0] = now();
                    if ($this->dates[1] == '')
                        $this->dates[1] = now();
                    $query->whereBetween('created_at', [$this->dates[0], $this->dates[1]]);
                })->count();

            // ->where('created_at', '>', now()->subMonth())
            if ($leadsCreated > 0) {
                array_push($dataUserCreatedLeads, $userCount->name);
                array_push($dataUserCountLeads, $leadsCreated);
            } else {
                if ($userCount->visible)
                    array_push($dataUserWithoutLeads, [$userCount->name . ' ' . $userCount->lastname, $userCount->last_login]);
            }
        }
        $this->dataUserInfoTickets = [$dataUserCreatedLeads, $dataUserCountLeads, $dataUserWithoutLeads];

        // Vendedores
        $dataUserMountLeads = [];
        $dataUserCountLeads = [];
        $users = User::all();
        foreach ($users as $userCount) {
            $leadsCreated = $userCount->quotes()
                ->when($start !== '' || $end !== '', function ($query, $dates) {
                    if ($this->dates[0] == '')
                        $this->dates[0] = now();
                    if ($this->dates[1] == '')
                        $this->dates[1] = now();
                    $query->whereBetween('created_at', [$this->dates[0], $this->dates[1]]);
                })->count();

            if ($leadsCreated > 0) {
                $mount = 0;
                $leadsByUser = $userCount->quotes()
                    ->when($start !== '' || $end !== '', function ($query, $dates) {
                        if ($this->dates[0] == '')
                            $this->dates[0] = now();
                        if ($this->dates[1] == '')
                            $this->dates[1] = now();
                        $query->whereBetween('created_at', [$this->dates[0], $this->dates[1]]);
                    })->get();
                foreach ($leadsByUser as $quote) {
                    $mount = $mount + ($quote->latestQuotesUpdate ? $quote->latestQuotesUpdate->quoteProducts->sum('precio_total') : 0);
                }
                array_push($dataUserMountLeads, $userCount->name);
                array_push($dataUserCountLeads, $mount);
            }
        }
        $this->dataUserMountTickets = [$dataUserMountLeads, $dataUserCountLeads];

        $this->dispatchBrowserEvent('refreshData', [
            'dataQuoteCompany' => $this->dataQuoteCompany,
            'dataUserInfoTickets' => $this->dataUserInfoTickets,
            'dataUserMountTickets' => $this->dataUserMountTickets
        ]);

        return view('livewire.dashboard-component');
    }
}
