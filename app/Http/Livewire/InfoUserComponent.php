<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use GuzzleHttp\Psr7\Request;

class InfoUserComponent extends Component
{
    public function render($id)
    {

        $data = User::where("id", $id)->select("users.*")->get();
        // $user = User::all()->where('id', $data);
        // $isChofer =  auth()->user()->where('id', $data)->first();
        dd($data);

        return view('livewire.info-user-component', compact('data'));
    }
}
