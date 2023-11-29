<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div class="">
                <h4><i class="fab fa-laravel text-info"></i>
                    Lista de Materiales</h4>
                    <p>Cuando los materiales y las tecnicas ya estan registradas, se puede agregar se pueden agregar tecnicas a los materias desde el boton acciones</p>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                @if (session()->has('message'))
                    <div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;">
                        {{ session('message') }} </div>
                @endif
                <div>
                    <input wire:model='keyWord' type="text" class="form-control" name="search" id="search"
                        placeholder="Buscar">
                </div>
                <div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataModal">
                    <i class="fa fa-plus"></i> Agregar Material
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        @include('livewire.materials.create')
        @include('livewire.materials.update')
        @include('livewire.materials.addTechnique')
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="thead">
                    <tr>
                        <td>#</td>
                        <th>Nombre</th>
                        <th>Extras</th>
                        <th>Tecnicas</th>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materials as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->nombre }}</td>
                            <td>{{ $row->extras }}</td>
                            <td>
                                @foreach ($row->materialTechniques as $item)
                                    {{ $item->nombre }}
                                @endforeach
                            </td>
                            <td width="90">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a data-toggle="modal" data-target="#addTecnicasModal" class="dropdown-item"
                                            wire:click="editListTechniques({{ $row->id }})"><i
                                                class="fa fa-edit"></i> Agregar Tecnicas </a>
                                        <a data-toggle="modal" data-target="#updateModal" class="dropdown-item"
                                            wire:click="edit({{ $row->id }})"><i class="fa fa-edit"></i> Editar
                                        </a>
                                        <a class="dropdown-item"
                                            onclick="confirm('Confirm Delete Material id {{ $row->id }}? \nDeleted Materials cannot be recovered!')||event.stopImmediatePropagation()"
                                            wire:click="destroy({{ $row->id }})"><i class="fa fa-trash"></i>
                                            Eliminar </a>
                                    </div>
                                </div>
                            </td>
                    @endforeach
                </tbody>
            </table>
            {{ $materials->links() }}
        </div>
    </div>
</div>
