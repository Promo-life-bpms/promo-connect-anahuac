<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createDataPTModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createDataPTModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataPTModalLabel">Create New Prices Technique</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
				<form>
            <div class="form-group">
                <label for="size_material_technique_id"></label>
                <select name="" id="">
                    <option value="">Selecciones la configuracion</option>

                </select>
                <input wire:model="size_material_technique_id" type="text" class="form-control" id="size_material_technique_id" placeholder="Size Material Technique Id">@error('size_material_technique_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="escala_inicial"></label>
                <input wire:model="escala_inicial" type="text" class="form-control" id="escala_inicial" placeholder="Escala Inicial">@error('escala_inicial') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="escala_final"></label>
                <input wire:model="escala_final" type="text" class="form-control" id="escala_final" placeholder="Escala Final">@error('escala_final') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="precio"></label>
                <input wire:model="precio" type="text" class="form-control" id="precio" placeholder="Precio">@error('precio') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="tipo_precio"></label>
                <input wire:model="tipo_precio" type="text" class="form-control" id="tipo_precio" placeholder="Tipo Precio">@error('tipo_precio') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal">Save</button>
            </div>
        </div>
    </div>
</div>
