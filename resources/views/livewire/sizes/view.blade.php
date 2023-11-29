    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h4><i class="fab fa-laravel text-info"></i> Tamaños </h4>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    @if (session()->has('message'))
                        <div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;">
                            {{ session('message') }} </div>
                    @endif
                    <div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataSizeModal">
                        <i class="fa fa-plus"></i> +
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            @include('livewire.sizes.create')
            @include('livewire.sizes.update')
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
                        @foreach ($sizes as $row)
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
                                            <a data-toggle="modal" data-target="#updateModalSize"
                                            class="dropdown-item"
                                                wire:click="edit({{ $row->id }})"><i class="fa fa-edit"></i>
                                                Editar </a>
                                        </div>
                                    </div>
                                </td>
                        @endforeach
                    </tbody>
                </table>
                {{ $sizes->links() }}
            </div>
        </div>
    </div>
