<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MaterialTechnique;
use Exception;

class MaterialTechniques extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $technique_id, $material_id;
    public $updateMode = false;

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        return view('livewire.material-techniques.view', [
            'materialTechniques' => MaterialTechnique::orWhere('technique_id', 'LIKE', $keyWord)
                ->orWhere('material_id', 'LIKE', $keyWord)
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
        $this->technique_id = null;
        $this->material_id = null;
    }

    public function store()
    {
        $this->validate([
            'technique_id' => 'required',
            'material_id' => 'required',
        ]);

        MaterialTechnique::create([
            'technique_id' => $this->technique_id,
            'material_id' => $this->material_id
        ]);

        $this->resetInput();
        $this->emit('closeModal');
        session()->flash('message', 'MaterialTechnique Successfully created.');
    }

    public function edit($id)
    {
        $record = MaterialTechnique::findOrFail($id);

        $this->selected_id = $id;
        $this->technique_id = $record->technique_id;
        $this->material_id = $record->material_id;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'technique_id' => 'required',
            'material_id' => 'required',
        ]);

        if ($this->selected_id) {
            $record = MaterialTechnique::find($this->selected_id);
            $record->update([
                'technique_id' => $this->technique_id,
                'material_id' => $this->material_id
            ]);

            $this->resetInput();
            $this->updateMode = false;
            session()->flash('message', 'MaterialTechnique Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = MaterialTechnique::where('id', $id);
            $record->delete();
        }
    }
}
