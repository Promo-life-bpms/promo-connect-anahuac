<div>
    <h3>Detalles del Cliente</h3>
    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Nombre de contacto</label>
                <input type="text" class="form-control" placeholder="Nombre" wire:model="nombre">
            </div>
            @if ($errors->has('nombre'))
                <span class="text-danger">{{ $errors->first('nombre') }}</span>
            @endif
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" class="form-control" placeholder="Correo electronico del contacto"
                    wire:model="email">
            </div>
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Telefono</label>
                <input type="tel" class="form-control" placeholder="Telefono del contacto" wire:model="telefono">
            </div>
            @if ($errors->has('telefono'))
                <span class="text-danger">{{ $errors->first('telefono') }}</span>
            @endif
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Celular</label>
                <input type="tel" class="form-control" placeholder="Celular del contacto" wire:model="celular">
            </div>
            @if ($errors->has('celular'))
                <span class="text-danger">{{ $errors->first('celular') }}</span>
            @endif
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Oportunidad</label>
                <input type="text" class="form-control" placeholder="Oportunidad" wire:model="oportunidad">
            </div>
            @if ($errors->has('oportunidad'))
                <span class="text-danger">{{ $errors->first('oportunidad') }}</span>
            @endif
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Probabilidad de Venta</label>
                <select name="tipo" class="form-control" wire:model="rank">
                    <option value="">Seleccione la Probabilidad de Venta</option>
                    <option value="1">Medio</option>
                    <option value="2">Alto</option>
                    <option value="3">Muy Alto</option>
                </select>
            </div>
            @if ($errors->has('rank'))
                <span class="text-danger">{{ $errors->first('rank') }}</span>
            @endif
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Departamento (opcional)</label>
                <input type="text" class="form-control" placeholder="Departamento" wire:model="departamento">
            </div>
            @if ($errors->has('departamento'))
                <span class="text-danger">{{ $errors->first('departamento') }}</span>
            @endif
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Como mostrar el IVA</label>
                <select name="tipo" class="form-control" wire:model="ivaByItem">
                    <option value="0">Mostrar el IVA en el monto total</option>
                    <option value="1">Mostrar el IVA por partida</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">El monto total es</label>
                <select name="tipo" class="form-control" wire:model="showTotal">
                    <option value="1">Visible</option>
                    <option value="0">No visible</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Los dias seran</label>
                <select name="tipo" class="form-control" wire:model="typeDays">
                    <option value="0">Habiles</option>
                    <option value="1">Naturales</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Tax Fee (Opcional)</label>
                <input type="number" class="form-control" placeholder="Tax Fee (Valor Maximo 99)" wire:model="taxFee"
                    max="99">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Vigencia de la cotizacion (Opcional)</label>
                <input type="number" class="form-control" placeholder="Duracion de la vigencia"
                    wire:model="shelfLife" max="99">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Informacion Adicional (Opcional)</label>
                <textarea name="" id="" cols="30" rows="2" class="form-control" wire:model="informacion"></textarea>
            </div>
            @if ($errors->has('informacion'))
                <span class="text-danger">{{ $errors->first('informacion') }}</span>
            @endif
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Logo del Cliente</label>
                <div class="form-group" x-data="{ isUploading: false, progress: 5 }" x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <input type="file" class="form-control" wire:model="logo" accept="image/*">
                    <div x-show="isUploading" class="progress">
                        <div class="progress-bar" role="progressbar" x-bind:style="`width: ${progress}%`"
                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                @if ($logo)
                    <p class="text-warning">Revisa que tenga fondo blanco o que se un archivo PNG
                    </p>
                    <div class="btn btn-danger btn-sm" wire:click="limpiarLogo()">Eliminar</div>
                @else
                    <p>No hay un logo de cliente cargado</p>
                @endif
            </div>
            @if ($errors->has('logo'))
                <span class="text-danger">{{ $errors->first('departamento') }}</span>
            @endif
        </div>
        <div class="col-md-4">
            <div class="form-group">
                @if ($logo)
                    <div class="text-center">
                        <p>Logo del cliente</p>
                        <img src="{{ $logo->temporaryUrl() }}" alt=""
                            style="max-width: 100%; height: auto; max-height: 150px; width: auto">
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-12">
            <div class="d-flex justify-content-center">
                <div wire:loading wire:target="guardarCotizacion">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">loading...</span>
                    </div>
                </div>
                <button class="btn btn-primary" wire:click="guardarCotizacion">Guardar Cambios</button>
            </div>
        </div>
    </div>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</div>
