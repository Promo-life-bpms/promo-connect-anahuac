<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Material;
use App\Models\Technique;
use Illuminate\Support\Str as Str;

class Materials extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre, $extras, $material;
    public $updateMode = false;

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        $techniques = Technique::all();
        return view('livewire.materials.view', [
            'materials' => Material::latest()
                ->orWhere('nombre', 'LIKE', $keyWord)
                ->orWhere('extras', 'LIKE', $keyWord)
                ->paginate(10),
            'techniques' => $techniques
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
        $this->extras = null;
        $this->material = null;
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required',
            'extras' => 'required',
        ]);

        Material::create([
            'nombre' => $this->nombre,
            'extras' => $this->extras,
            'slug' => Str::slug($this->nombre)
        ]);

        $this->resetInput();
        $this->emit('closeModal');
        session()->flash('message', 'Material Successfully created.');
    }

    public function edit($id)
    {
        $record = Material::findOrFail($id);

        $this->selected_id = $id;
        $this->nombre = $record->nombre;
        $this->extras = $record->extras;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required',
            'extras' => 'required',
        ]);

        if ($this->selected_id) {
            $record = Material::find($this->selected_id);
            $record->update([
                'nombre' => $this->nombre,
                'extras' => $this->extras,
                'slug' => Str::slug($this->nombre)
            ]);

            $this->resetInput();
            $this->updateMode = false;
            session()->flash('message', 'Material Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Material::where('id', $id);
            $record->delete();
        }
    }

    public function editListTechniques($id)
    {
        $record = Material::findOrFail($id);
        $this->material = $record;
        $this->updateMode = true;
    }

    public function updateListTechniques($technique_id)
    {
        $technique = Technique::find($technique_id);
        $this->material->materialTechniques()->toggle($technique);
        session()->flash('updateSites', 'Actualizacion correcta.');
    }
}
