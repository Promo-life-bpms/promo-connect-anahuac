            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="">
                            <h4><i class="fab fa-laravel text-info"></i>
                                Tecnicas </h4>
                        </div>
                        <div class="d-flex justify-content-between">
                            @if (session()->has('message'))
                                <div wire:poll.4s class="btn btn-sm btn-success"
                                    style="margin-top:0px; margin-bottom:0px;">
                                    {{ session('message') }} </div>
                            @endif
                            <div>
                                <input wire:model='keyWord' type="text" class="form-control" name="search"
                                    id="search" placeholder="Buscar">
                            </div>
                            <div class="btn btn-sm btn-info" data-toggle="modal"
                                data-target="#createDataModalTechnique">
                                <i class="fa fa-plus"></i> Agregar Tecnica
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('livewire.techniques.create')
                    @include('livewire.techniques.update')
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead">
                                <tr>
                                    <td>#</td>
                                    <th>Nombre</th>
                                    <td>Acciones</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($techniques as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->nombre }}</td>
                                        <td width="90">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Acciones
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a data-toggle="modal" data-target="#updateModalTechnique"
                                                        class="dropdown-item" wire:click="edit({{ $row->id }})"><i
                                                            class="fa fa-edit"></i> Editar </a>
                                                    <a class="dropdown-item"
                                                        onclick="confirm('Confirm Delete Technique id {{ $row->id }}? \nDeleted Techniques cannot be recovered!')||event.stopImmediatePropagation()"
                                                        wire:click="destroy({{ $row->id }})"><i
                                                            class="fa fa-trash"></i> Delete </a>
                                                </div>
                                            </div>
                                        </td>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $techniques->links() }}
                    </div>
                </div>
            </div>
