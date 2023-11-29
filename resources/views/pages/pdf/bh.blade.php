<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cotizacion BH</title>
    <link rel="stylesheet" href="quotesheet/bh/stylebh.css">
</head>

<body>
    @guest
        @php
            $user = $quote->user;
        @endphp
    @else
        @php
            $user = auth()->user();
            if (auth()->user()->id !== $quote->user_id) {
                $user = $quote->user;
            }
        @endphp
    @endguest
    <header>
        {{-- <img src="quotesheet/bh/triangulos.png" alt="" srcset="" class="fondo-head"> --}}
        <table class="head content">
            <tr>
                <td style="text-align: left; width:20%"><img src="quotesheet/bh/logo.png" class="logo"></td>
                <td style="text-align: center; width:65%">Presupuesto | Compañia</td>
                <td></td>
            </tr>
        </table>
        <p class="company-name content">BH Trade Market S.A. de C.V.</p>
    </header>
    <footer>
        <table class="footer content">
            <tr>
                <td colspan="3" style="text-align: center">www.trademarket.com.mx</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center; font-size: 10px;">San Andrés Atoto 155A Naucalpan de
                    Juárez, Méx. C.P. 53550
                    Tel. +52(55) 5290 9100</td>
            </tr>
        </table>
        <div style="text-align: right">
            <p class="content">Pagina <span class="pagenum"></span></p>
        </div>
    </footer>
    <div class="body-pdf">
        @if ($quote->logo != null)
            <div class="content" style="width: 50%; text-align: center; margin-bottom: 10px;">
                <img src="{{ $quote->logo }}"
                    style="max-height: 130px; width: auto;  max-width: 45%;margin-bottom: 10px;">
            </div>
        @endif
        @if ($nombreComercial)
            <p class="content" style="font-size: 20px;"> <b>{{ $nombreComercial->name }}</b></p>
        @else
            <p class="content" style="font-size: 20px;">
                <b>{{ $quote->latestQuotesUpdate->quotesInformation->company }}</b>
            </p>
        @endif
        <table class="cliente content">
            <tr>
                <td style="width: 50%">

                    <p>Contacto: {{ $quote->latestQuotesUpdate->quotesInformation->name }}</p>
                    <p>Departamento: {{ $quote->latestQuotesUpdate->quotesInformation->department }}</p>

                </td>
                <td style="width: 50%">
                    <p>Cotización: QS{{ $quote->id }}</p>
                    <p>Fecha Cotización: {{ $quote->created_at->format('d/m/Y') }}</p>
                </td>
            </tr>
        </table>
        <table class="content  info-client">
            <tr>
                <td> <img src="quotesheet/bh/icon-whatsapp.png" alt=""> </td>
                <td style="vertical-align: middle"> {{ $user->phone == null ? 'Sin Dato' : $user->phone }} </td>
                <td><img src="quotesheet/bh/icon-email.png" alt=""></td>
                <td style="vertical-align: middle">{{ $user->email }}</td>
            </tr>
        </table>
        <div class="content">
            <hr>
            <p style="font-size: 17px; padding: 0px 0 12px 0; font-weight: bold;">En respuesta a tu solicitud para
                cotizarte, ponemos a tu disposición las siguientes
                propuestas:
            </p>
        </div>
        @php
            $taxFee = 1 + ((int) $quote->latestQuotesUpdate->quotesInformation->tax_fee) / 100;
            $quote_scales = false;
        @endphp
        <div class="content body-products">
            <style>
                td {
                    vertical-align: top;
                }

                .body-products table {
                    page-break-inside: avoid;
                }

                .body-products tr.title {
                    background-color: black;
                    color: white;
                    text-align: center;
                    font-size: 17px;
                    font-weight: bold;
                }

                .body-products td {
                    padding: 5px 0 5px 0;
                    font-size: 16px;
                }

                .body-products td .descripcion {
                    padding: 5px 5px 5px 5px;
                    text-align: justify;
                }

                .body-products td.title-tecnica {
                    text-align: center;
                    font-weight: bold;
                    color: white;
                    background-color: rgb(20, 20, 20);
                }

                .body-products td.detalle-tecnica {
                    text-align: center;
                    color: black;
                    background-color: rgb(251, 251, 251);
                }

                .body-products td.title-entrega {
                    margin: 5px 0 5px 0;
                    text-align: center;
                    font-weight: bold;
                    color: black;
                    background-color: rgb(251, 251, 251);
                }

                .body-products td.title-cantidad {
                    text-align: center;
                    font-weight: bold;
                    color: white;
                    background-color: rgb(20, 20, 20);
                }

                .body-products td.detalle-cantidad {
                    text-align: center;
                    color: black;
                    background-color: rgb(251, 251, 251);
                    vertical-align: middle;
                }
            </style>
            @foreach ($quote->latestQuotesUpdate->quoteProducts as $item)
                @php
                    $producto = json_decode($item->product);
                    $tecnica = json_decode($item->technique);
                    $scales_info = json_decode($item->scales_info);
                    if ($item->quote_by_scales) {
                        $quote_scales = true;
                    }
                @endphp
                <table style="border-collapse: collapse;width:100%;border: 1px solid black">
                    <tr class="title">
                        <td>
                            <p class="title-text">Imagen de Referencia</p>
                        </td>
                        <td colspan="12">
                            <p class="title-text">Descripcion</p>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="{{ $item->quote_by_scales ? 5 + count($scales_info) : 6 }}"
                            style="width: 250px; text-align: center; vertical-align: middle; padding: 0; border-right: 1px solid black">
                            @if ($producto->image)
                                <img src="{{ $producto->image }}"
                                    style="max-height: 220px;height:auto;max-width: 220px;width:auto;">
                            @else
                                <img src="img/default.jpg" width="180">
                            @endif
                        </td>
                        <td colspan="12">
                            <p class="descripcion">
                                {{ $item->new_description ? $item->new_description : $producto->description }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="title-tecnica">Tecnica de Personalizacion</td>
                        <td colspan="6" class="title-tecnica">Detalle de la Personalizacion</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="detalle-tecnica">
                            {{ $tecnica->tecnica }}
                        </td>
                        <td colspan="6" class="detalle-tecnica">
                            @if ($tecnica->tecnica !== 'No Aplica')
                                <p style="font-size: 14px"><b>Tintas: </b>{{ $item->color_logos }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12" class="title-entrega">Tiempo de Entrega: {{ $item->dias_entrega }} días.</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="title-cantidad">Cantidad</td>
                        <td colspan="4" class="title-cantidad">Precio Unitario</td>
                        <td colspan="4" class="title-cantidad">Precio Total</td>
                    </tr>
                    @if ($item->quote_by_scales)
                        @foreach ($scales_info as $scale)
                            <tr>
                                <td colspan="4" class="detalle-cantidad">{{ $scale->quantity }} pz</td>
                                <td colspan="4" class="detalle-cantidad">$
                                    {{ number_format($scale->unit_price * $taxFee, 2, '.', ',') }}

                                </td>
                                <td colspan="4" class="detalle-cantidad">$
                                    {{ number_format($scale->total_price * $taxFee, 2, '.', ',') }}
                                    @if ($quote->iva_by_item)
                                        <p style="font-size: 12px"><b>IVA:
                                            </b>${{ number_format($scale->total_price * $taxFee * 0.16, 2, '.', ',') }}
                                        </p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="detalle-cantidad">{{ $item->cantidad }} pz</td>
                            <td colspan="4" class="detalle-cantidad">$
                                {{ number_format($item->precio_unitario * $taxFee, 2, '.', ',') }}

                            </td>
                            <td colspan="4" class="detalle-cantidad">$
                                {{ number_format($item->precio_total * $taxFee, 2, '.', ',') }}
                                @if ($quote->iva_by_item)
                                    <p style="font-size: 12px"><b>IVA:
                                        </b>${{ number_format($item->precio_total * $taxFee * 0.16, 2, '.', ',') }}
                                    </p>
                                @endif
                            </td>
                        </tr>
                    @endif
                </table>
                <div style="height: 20px;"></div>
            @endforeach
        </div>
        <hr>
        <br>
        <table class="total content">
            <tr style="">
                <td style="width: 100%; font-size: 15px;">
                    <p style="margin-bottom: 5px">Cotización Válida Hasta:
                        {{ $quote->created_at->addDays($quote->latestQuotesUpdate->quotesInformation->shelf_life ?: 30)->format('d/m/Y') }}
                    </p>
                    <br>
                    @if (strlen($quote->latestQuotesUpdate->quotesInformation->information) > 0)
                        <p style="text-align: justify"><span style="font-weight: bold;"> Información Adicional:</span>
                            {{ $quote->latestQuotesUpdate->quotesInformation->information }}</p>
                    @endif
                    <br>
                </td>
            </tr>
            @if (!$quote_scales)
                @if ($quote->show_total)
                    <tr>
                        @php
                            $subtotal = (isset($quote->preview) ? $quote->precio_total : $quote->latestQuotesUpdate->quoteProducts->sum('precio_total')) * $taxFee;
                            $discount = 0;
                            if ($quote->latestQuotesUpdate->quoteDiscount->type == 'Fijo') {
                                $discount = $quote->latestQuotesUpdate->quoteDiscount->value;
                            } else {
                                $discount = round(($subtotal / 100) * $quote->latestQuotesUpdate->quoteDiscount->value, 2);
                            }
                            $iva = round($subtotal * 0.16, 2);
                        @endphp
                        <td style="width: 100%; text-align: right">
                            <p><b>Subtotal: </b> $ {{ number_format($subtotal, 2, '.', ',') }}</p>
                            @if ($discount > 0)
                                <p><b>Descuento: </b>$ {{ number_format($discount, 2, '.', ',') }}</p>
                            @endif
                            @if (!$quote->iva_by_item)
                                <p><b>IVA: </b> $ {{ number_format($iva, 2, '.', ',') }}</p>
                            @endif
                            <br>
                            <p><b>Total: </b>$ {{ number_format($subtotal - $discount + $iva, 2, '.', ',') }}</p>
                        </td>
                    </tr>
                @endif
            @endif
        </table>
    </div>
    <br>
    <div class="content condiciones">
        <p> Condiciones:</p>
        <ul>
            <li>Condiciones de pago acordadas con el vendedor</li>
            <li>Precios unitarios mostrados antes de IVA</li>
            <li>Precios mostrados en pesos mexicanos (MXP)</li>
            <li>El importe cotizado corresponde a la cantidad de piezas y número de tintas arriba mencionadas, si se
                modifica
                el número de piezas el precio cambiaría.</li>
            <li>El tiempo de entrega empieza a correr una vez recibida la Orden de Compra y autorizada la muestra física
                o
                virtual a solicitud del cliente.</li>
            <li>Vigencia de la cotización {{ $quote->latestQuotesUpdate->quotesInformation->shelf_life ?: 30 }} días
                {{ $quote->type_days == 0 ? 'hábiles' : 'naturales' }}.</li>
            <li>Producto cotizado de fabricación nacional o importación puede afinarse la fecha de entrega previo a la
                emisión
                de Orden de Compra.</li>
            <li>Producto cotizado disponible en stock a la fecha de esta cotización puede modificarse al paso de los
                días
                sin
                previo aviso. Solo se bloquea el inventario al recibir Orden de Compra</li>
        </ul>
    </div>
</body>

</html>
