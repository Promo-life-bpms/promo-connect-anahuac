<?php

namespace App\Http\Livewire;

use App\Models\Material;
use App\Models\MaterialTechnique;
use App\Models\Size;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SizeMaterialTechnique;
use App\Models\Technique;

class SizeMaterialTechniques extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $size_id, $material_technique_id, $material;
    public $updateMode = false;

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        return view('livewire.size-material-techniques.view', [
            'sizeMaterialTechniques' => MaterialTechnique::orderby('material_id', 'asc')->paginate(10),
            'sizes' => Size::all(),
            'materialsTechniques' => MaterialTechnique::all()
        ]);
    }

    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }

    private function resetInput()
    {
        $this->size_id = null;
        $this->material_technique_id = null;
    }


    public function edit($id)
    {
        $record = MaterialTechnique::findOrFail($id);
        $this->material = $record;
        $this->updateMode = true;
    }

    public function updateSizes($size_id)
    {
        $size = Size::find($size_id);
        $this->material->sizeMaterialTechniques()->toggle($size);
        session()->flash('updateSites', 'Actualizacion correcta.');
    }
}
