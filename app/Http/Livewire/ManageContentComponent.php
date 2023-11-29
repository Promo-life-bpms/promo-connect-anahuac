<?php

namespace App\Http\Livewire;

use App\Models\Banner;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ManageContentComponent extends Component
{
    use WithPagination, WithFileUploads;
    public $banner, $searchBanner;

    public function render()
    {
        $banners = Banner::where('visible', true)->paginate(10);
        return view('livewire.manage-content-component', compact('banners') );
    }

    // agregar un banner
    public function addBanner()
    {
        $this->validate([
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5096',
        ]);

        $imageName = time() . '.' . $this->banner->extension();
        $this->banner->storeAs('public/banners', $imageName);

        Banner::create([
            'url_banner' => $imageName,
            'user_id' => auth()->user()->id,
        ]);

        session()->flash('message', 'Banner agregado correctamente.');
      
    }

    // Ocultar un banner
    public function hideBanner($id)
    {
        $banner = Banner::find($id);
        $banner->visible = false;
        $banner->save();
        session()->flash('message', 'Banner ocultado correctamente.');
    }

    // Modificar la imagen del banner
    public function updateBanner($id)
    {
        $this->validate([
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time() . '.' . $this->banner->extension();
        $this->banner->storeAs('public/banners', $imageName);

        $banner = Banner::find($id);
        $banner->url_banner = $imageName;
        $banner->save();

        session()->flash('message', 'Banner modificado correctamente.');
    }

    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }
}
