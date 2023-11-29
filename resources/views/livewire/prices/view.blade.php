<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <h4><i class="fab fa-laravel text-info"></i>
                                Listado de Precios</h4>
                        </div>
                        @if (session()->has('message'))
                            <div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;">
                                {{ session('message') }} </div>
                        @endif
                        <div>
                            <input wire:model='keyWord' type="text" class="form-control" name="search"
                                id="search" placeholder="Search Prices Techniques">
                        </div>
                        {{-- <div class="btn btn-sm btn-info" data-toggle="modal" data-target="#createDataPTModal">
                            <i class="fa fa-plus"></i> Add Prices Techniques
                        </div> --}}
                    </div>
                </div>

                <div class="card-body">
                    {{-- @include('livewire.prices.create') --}}
                    @include('livewire.prices.update')
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead">
                                <tr>
                                    <th>#</th>
                                    <th>Tamaños de las tecnicas</th>
                                    <th>Escala Inicial</th>
                                    <th>Escala Final</th>
                                    <th>Precio</th>
                                    <th>Tipo Precio</th>
                                    <td>Acciones</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sizeMaterialTechniques as $row)
                                    @php
                                        $it = $loop->iteration;
                                    @endphp
                                    @foreach ($row->pricesTechniques as $key => $price)
                                        <tr>
                                            @if ($key == 0)
                                                <td rowspan="{{ $row->pricesTechniques->count() }}" colspan="1">
                                                    {{ $it }}</td>
                                                <td rowspan="{{ $row->pricesTechniques->count() }}" colspan="1">
                                                    <b>{{ $row->materialTechnique->material->nombre }}</b>
                                                    {{ $row->materialTechnique->technique->nombre . ' ' . $row->size->nombre }}
                                                </td>
                                            @endif
                                            <td>
                                                <p class="m-0"> {{ $price->escala_inicial }}</p>
                                            </td>
                                            <td>
                                                <p class="m-0"> {{ $price->escala_final }}</p>
                                            </td>
                                            <td>
                                                <p class="m-0"> {{ $price->precio }}</p>
                                            </td>
                                            <td>
                                                <p class="m-0">
                                                    {{ $price->tipo_precio == 'D' ? 'Fijo' : 'Por Unidad' }}</p>
                                            </td>
                                            <td width="90" class="p-0">
                                                <a data-toggle="modal" data-target="#updateModalPrice"
                                                    class="btn btn-sm btn-info px-2 py-1"
                                                    wire:click="edit({{ $price->id }})">
                                                    Editar </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                        {{ $sizeMaterialTechniques->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
