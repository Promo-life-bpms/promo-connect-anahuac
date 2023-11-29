<!-- Modal -->
<div wire:ignore.self class="modal fade" id="addTecnicasModal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="addTecnicasModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTecnicasModalLabel">Actualizar Tecnicas del Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @if ($material != null)
                        @foreach ($techniques as $technique)
                            @php
                                $check = false;
                            @endphp
                            @foreach ($material->materialTechniques as $item)
                                @php
                                    if ($item->id == $technique->id) {
                                        $check = true;
                                    }
                                @endphp
                            @endforeach
                            <li class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $technique->id }}"
                                        id="check{{ $technique->id }}"
                                        wire:click="updateListTechniques({{ $technique->id }}, {{ $material->id }})"
                                        {{ $check ? 'checked' : '' }}>
                                    <label class="form-check-label" for="check{{ $technique->id }}">
                                        {{ $technique->nombre }}
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
                @if (session()->has('updateSites'))
                    <div wire:poll.3s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;">
                        {{ session('updateSites') }} </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
