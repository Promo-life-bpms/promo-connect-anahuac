<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Size;

use Illuminate\Support\Str as Str;

class Sizes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre;
    public $updateMode = false;

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        return view('livewire.sizes.view', [
            'sizes' => Size::latest()
                ->orWhere('nombre', 'LIKE', $keyWord)
                ->paginate(10),
        ]);
    }

    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }

    private function resetInput()
    {
        $this->nombre = null;
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required',
        ]);

        Size::create([
            'nombre' => $this->nombre,
            'slug' => Str::slug($this->nombre)
        ]);

        $this->resetInput();
        $this->emit('closeModal');
        session()->flash('message', 'Size Successfully created.');
    }

    public function edit($id)
    {
        $record = Size::findOrFail($id);

        $this->selected_id = $id;
        $this->nombre = $record->nombre;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required',
        ]);

        if ($this->selected_id) {
            $record = Size::find($this->selected_id);
            $record->update([
                'nombre' => $this->nombre,
                'slug' => Str::slug($this->nombre)
            ]);

            $this->resetInput();
            $this->updateMode = false;
            session()->flash('message', 'Size Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Size::where('id', $id);
            $record->delete();
        }
    }
}
