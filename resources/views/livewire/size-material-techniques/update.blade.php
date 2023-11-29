<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Agregar Tamaños</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span wire:click.prevent="cancel()" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($material != null)
                    <strong>{{ $material->material->nombre }}</strong> {{ $material->technique->nombre }}
                @endif
                <br>
                <ul class="list-group">
                    @if ($material != null)
                        @foreach ($sizes as $size)
                            @php
                                $check = false;
                            @endphp
                            @foreach ($material->sizeMaterialTechniques as $item)
                                @php
                                    if ($item->id == $size->id) {
                                        $check = true;
                                    }
                                @endphp
                            @endforeach
                            <li class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $size->id }}"
                                        id="check{{ $size->id }}"
                                        wire:click="updateSizes({{ $size->id }}, {{ $material->id }})"
                                        {{ $check ? 'checked' : '' }}>
                                    <label class="form-check-label" for="check{{ $size->id }}">
                                        {{ $size->nombre }}
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
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
