<div>
    <div class="row px-3">
        <div class="card w-100">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Valores</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($settings as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            @switch($item->slug)
                                @case('providers')
                                    @php
                                        $providersId = trim($item->value) == '' ? [] : explode(',', trim($item->value));
                                        $proveedoresSeleccionados = $providers->whereIn('id', $providersId);
                                        $proveedoresSeleccionados = $proveedoresSeleccionados->pluck('company')->toArray();
                                    @endphp
                                    <td>
                                        @if (count($proveedoresSeleccionados) > 0)
                                            {{ implode(', ', $proveedoresSeleccionados) }}
                                        @else
                                            <p>No hay proveedores seleccionados</p>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm"data-toggle="modal"
                                            data-target="#modalProvedores">Editar</button>
                                    </td>
                                @break

                                @default
                            @endswitch
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modalProvedores" tabindex="-1" aria-labelledby="modalProvedoresLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProvedoresLabel">Seleccionar Provvedores Visibles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php
                        $providersIdSelected = trim($item->value) == '' ? [] : explode(',', trim($item->value));
                    @endphp
                    @foreach ($providers as $provider)
                    @php
                        $checked = false;
                    @endphp
                        @foreach ($providersIdSelected as $pSelected)
                            @if ($provider->id == $pSelected)
                                @php
                                    $checked = true;
                                    break;
                                @endphp
                            @endif
                        @endforeach
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" {{ $checked ? 'checked' : ''  }}
                                value="{{ $provider->id }}" wire:click='saveProviders({{ $provider->id }})'>
                            <label class="form-check-label" for="inlineCheckbox1">{{ $provider->company }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
