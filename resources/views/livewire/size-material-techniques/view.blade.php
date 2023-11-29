@section('title', __('Configuracion de los tamaños'))
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div class="float-left">
                <h4><i class="fab fa-laravel text-info"></i>
                    Materiales y Tecnicas con su tamaño </h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('livewire.size-material-techniques.update')
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="thead">
                    <tr>
                        <td>#</td>
                        <th>Material y Tecnica</th>
                        <th>Tamaño</th>
                        <td>ACTIONS</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sizeMaterialTechniques as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $row->material->nombre }}</strong> {{ $row->technique->nombre }}</td>
                            <td>
                                @foreach ($row->sizeMaterialTechniques as $item)
                                    {{ $item->nombre }},
                                @endforeach
                            </td>
                            <td width="90">
                                <div class="btn-group">
                                    <a data-toggle="modal" data-target="#updateModal" class="btn btn-info btn-sm"
                                        wire:click="edit({{ $row->id }})"><i class="fa fa-edit"></i> Agregar
                                        Tamaños </a>

                                </div>
                            </td>
                    @endforeach
                </tbody>
            </table>
            {{ $sizeMaterialTechniques->links() }}
        </div>
    </div>
</div>
