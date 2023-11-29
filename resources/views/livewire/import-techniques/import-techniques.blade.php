<div>
    <style>
        .lds-dual-ring {
            display: inline-block;
            width: 30px;
            height: 30px;
        }

        .lds-dual-ring:after {
            content: " ";
            display: block;
            width: 24px;
            height: 24px;
            margin: 8px;
            border-radius: 50%;
            border: 6px solid #1FADD3;
            border-color: #1FADD3 transparent #1FADD3 transparent;
            animation: lds-dual-ring 1.2s linear infinite;
        }

        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div class="d-flex h-100 w-100 justify-content-center align-items-center">
        <div class="row justify-content-center card">
            <div class="col-md-12 text-center">
                <h3 class="m-0">Nueva Importacion de Tecnicas</h3>
                <p>Seleccione un archivo compatible (.xlsx) para comenzar la importacion</p>
                <p class="text-danger">Al crear una nueva importacion, se eliminaran los registros anteriores</p>
            </div>
            <div class="w-100">
            </div>
            <div class="col-md-12">
                @if (session()->has('error'))
                    <div wire:poll.5s class="alert alert-danger w-100" style="margin-top:0px; margin-bottom:0px;">
                        {!! session('error') !!}</div>
                @endif
                @if (session()->has('message'))
                    <div wire:poll.5s class="alert alert-success w-100" style="margin-top:0px; margin-bottom:0px;">
                        {!! session('message') !!}</div>
                @endif
                <form wire:submit.prevent="save">
                    <div class="">
                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                <label for="">Selecionar Archivo</label>
                                <div wire:loading>
                                    <div class="lds-dual-ring"></div>
                                </div>
                            </div>
                            <input type="file"
                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                class="form-control" wire:model="fileLayout">
                            @error('fileLayout')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <br>
                        <div class="form-group text-center mt-3">
                            <button type="submit" class="btn btn-success">Importar</button>
                        </div>
                    </div>
                </form>
                @error('fileLayout.*')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12">
                <p><strong>El archivo de excel debe tener el siguiente formato</strong></p>
                <p><strong>Material:</strong> Nombre del Material</p>
                <p><strong>Escala Inicial:</strong> Escala Inicial del Precio del producto en piezas</p>
                <p><strong>Escala Final:</strong> Escala Final del Precio del producto en piezas, cuando no hay un
                    final, colocar " - "</p>
                <p><strong>Tecnica:</strong> Nombre de la tecnica de personalizacion</p>
                <p><strong>Tamaño:</strong> Tamaño del personalizado</p>
                <p><strong>Precio:</strong> Precio de la perzonalizacion</p>
                <p><strong>Tipo:</strong> Si es general: <strong>D (Divisible)</strong>, Si es por pieza: <strong>F
                        (Fijo)</strong></p>
                <p class="text-danger">No debe quedar ningun campo vacio y tienen que estar todas las columnas</p>
                <table class="table">
                    <thead>
                        <th>Materiales</th>
                        <th>Escala Inicial</th>
                        <th>Escala Final</th>
                        <th>Tecnica</th>
                        <th>Tamaño</th>
                        <th>Precio</th>
                        <th>Tipo</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Plastico, Madera, Curpie, L. Acrilico</td>
                            <td>1</td>
                            <td>1000</td>
                            <td>Serigrafia</td>
                            <td>Cuarto de Hoja</td>
                            <td>550</td>
                            <td>D</td>
                        </tr>
                        <tr>
                            <td>Plastico, Madera, Curpie, L. Acrilico</td>
                            <td>1</td>
                            <td>1000</td>
                            <td>Serigrafia</td>
                            <td>Medio de Hoja</td>
                            <td>800</td>
                            <td>D</td>
                        </tr>
                        <tr>
                            <td>Plastico, Madera, Curpie, L. Acrilico</td>
                            <td>1</td>
                            <td>1000</td>
                            <td>Serigrafia</td>
                            <td>Hoja Completa</td>
                            <td>900</td>
                            <td>D</td>
                        </tr>
                        <tr>
                            <td>Plastico, Madera, Curpie, L. Acrilico</td>
                            <td>1001</td>
                            <td>10000</td>
                            <td>Serigrafia</td>
                            <td>Hoja Completa</td>
                            <td>0.55</td>
                            <td>F</td>
                        </tr>
                        <tr>
                            <td>Plastico, Madera, Curpie, L. Acrilico</td>
                            <td>1001</td>
                            <td>10000</td>
                            <td>Serigrafia</td>
                            <td>Hoja Completa</td>
                            <td>0.8</td>
                            <td>F</td>
                        </tr>
                        <tr>
                            <td>Plastico, Madera, Curpie, L. Acrilico</td>
                            <td>1001</td>
                            <td>10000</td>
                            <td>Serigrafia</td>
                            <td>Hoja Completa</td>
                            <td>0.95</td>
                            <td>F</td>
                        </tr>
                        <tr>
                            <td>Plastico, Madera, Curpie, L. Acrilico</td>
                            <td>10001</td>
                            <td>-</td>
                            <td>Serigrafia</td>
                            <td>Hoja Completa</td>
                            <td>0.45</td>
                            <td>F</td>
                        </tr>
                        <tr>
                            <td>Plastico, Madera, Curpie, L. Acrilico</td>
                            <td>10001</td>
                            <td>-</td>
                            <td>Serigrafia</td>
                            <td>Hoja Completa</td>
                            <td>0.5</td>
                            <td>F</td>
                        </tr>
                        <tr>
                            <td>Plastico, Madera, Curpie, L. Acrilico</td>
                            <td>10001</td>
                            <td>-</td>
                            <td>Serigrafia</td>
                            <td>Hoja Completa</td>
                            <td>0.65</td>
                            <td>F</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
