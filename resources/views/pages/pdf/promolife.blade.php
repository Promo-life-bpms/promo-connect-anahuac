<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cotización Promo Life</title>
    <link rel="stylesheet" href="quotesheet/pl/style.css">
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
        {{-- <img src="quotesheet/pl/fondo-azul-superior.png" alt="" srcset="" class="fondo-head"> --}}
        <div class="fondo-head"></div>
        <div class="content" style="text-align: right">
            <img src="quotesheet/pl/logo.png" class="logo">
        </div>
        <div class="content">
            <div style="margin-top: -40px;">
                <div style="width: 280px; padding-bottom: 10px;">
                    <span class="titulo1">Cotización</span>
                </div>
                <div style="width: 280px; text-align: center">
                    <span class="titulo2">QUOTATION SHEET</span>
                </div>
            </div>
        </div>
    </header>
    <footer>
        <p style="font-size: 12px; margin-left:3px; color:#000; text-align: right;" class="content">Pagina <span
                class="pagenum"></span> </p>
        <table
            style="magin-bottom: 0mm; position: absolute; bottom: 27mm; z-index: 10; width: 100%;background-color: rebeccapurple">
            {{-- {{ dd(1) }} --}}
            <tr style="background-color: rebeccapurple">
                <td style="background-color: rebeccapurple">
                    <div class="url"style="font-size: 15px; color:#fff ;">
                        <b>www.promolife.com.mx</b>
                    </div>
                </td>
            </tr>
        </table>

        <table style="magin-bottom: 0mm; position: absolute; bottom:70px; z-index:100;" class="content">
            <tr>
                <td>
                    <p style="font-size: 12px; color:#0b216e ;">
                        <span style="top: -15px; left: 38px;">
                            San Andr&#233;s Atoto 155, San Est&#233;ban, Naucalpan, Edo. Méx. C.P. 53550 <br>
                    </p>
                    </span>
                    <p style="font-size: 12px; color:#0b216e ;"> Tel. +52(55) 62690017 </p>
                </td>
            </tr>
        </table>
    </footer>
    <div class="body-pdf">
        @if ($quote->logo != null)
            <div class="content" style="width: 280px; text-align: center; margin-bottom: 10px;">
                <img src="{{ $quote->logo }}"
                    style="max-height: 130px; width: auto; max-width: 260px;margin-bottom: 10px;">
            </div>
        @endif
        @if ($nombreComercial)
            <p class="content" style="font-size: 20px;"> <b>{{ $nombreComercial->name }}</b></p>
        @else
            <p class="content" style="font-size: 20px;">
                <b>{{ $quote->latestQuotesUpdate->quotesInformation->company }}</b>
            </p>
        @endif
        </p>
        <table class="cliente content">
            <tr>
                <td style="width: 60%">
                    <p><b>Contacto:</b> {{ $quote->latestQuotesUpdate->quotesInformation->name }}</p>
                    <p><b>Departamento:</b>
                        {{ $quote->latestQuotesUpdate->quotesInformation->department ? $quote->latestQuotesUpdate->quotesInformation->department : 'Sin Informacion' }}
                    </p>
                </td>
                <td style="width: 40%">
                    <p><b># Cotización:</b> QS{{ $quote->id }}</p>
                    <p><b>Fecha de cotización:</b> {{ $quote->created_at->format('d/m/Y') }}</p>
                </td>
            </tr>
        </table>
        <div class="content">
            <hr>
            <p style="font-size: 16.5px; padding: 0px 0 12px 0; font-weight: bold;">En respuesta a tu solicitud para
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
                    background-color: #1485cc;
                    color: white;
                    text-align: center;
                    font-size: 17px;
                    font-weight: bold;
                }

                .body-products td {
                    padding: 5px 0 5px 0;
                    font-size: 16px;
                    vertical-align: middle;
                }

                .body-products td .descripcion {
                    padding: 5px 5px 5px 5px;
                    text-align: justify;
                }

                .body-products td.title-tecnica {
                    text-align: center;
                    font-weight: bold;
                    color: white;
                    background-color: #1485cc;
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
                    background-color: #1485cc;
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
                <table style="border-collapse: collapse;width:100%;border: 1px solid #1485cc">
                    <tr class="title">
                        <td>
                            <p class="title-text" style="margin: 3px 0 3px 0">Imagen de Referencia</p>
                        </td>
                        <td colspan="12">
                            <p class="title-text" style="margin: 3px 0 3px 0">Descripción</p>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="{{ $item->quote_by_scales ? 5 + count($scales_info) : 6 }}"
                            style="width: 250px; text-align: center; vertical-align: middle; padding: 0; border-right: 1px solid #1485cc">
                            @if ($producto->image)
                                <img src="{{ $producto->image }}"
                                    style="max-height: 220px;height:auto;max-width: 220px;width:auto;">
                            @else
                                <img src="img/default.jpg" width="180">
                            @endif
                        </td>
                        <td colspan="12">
                            <p class="descripcion" style="line-height: 15px">
                                {{ $item->new_description ? $item->new_description : $producto->description }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="title-tecnica" style="margin: 1px 0 1px 0">
                            <p style="margin: 2px 0 2px 0">Técnica de Personalización</p>
                        </td>
                        <td colspan="6" class="title-tecnica" style="margin: 1px 0 1px 0">
                            <p style="margin: 2px 0 2px 0">Detalle de la Personalización</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="detalle-tecnica" style="margin: 3px 0 3px 0">
                            <p>{{ $tecnica->tecnica }}</p>
                        </td>
                        <td colspan="6" class="detalle-tecnica" style="margin: 3px 0 3px 0">
                            @if ($tecnica->tecnica !== 'No Aplica')
                                <p style="font-size: 14px"><b>Tintas: </b>{{ $item->color_logos }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12" class="title-entrega">
                            <p>Tiempo de Entrega: {{ $item->dias_entrega }} días
                                {{ $quote->type_days == 0 ? 'hábiles' : 'naturales' }}.</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="title-cantidad" style="margin: 1px 0 1px 0">
                            <p style="margin: 2px 0 2px 0">Cantidad </p>
                        </td>
                        <td colspan="4" class="title-cantidad" style="margin: 1px 0 1px 0">
                            <p style="margin: 2px 0 2px 0">Precio Unitario </p>
                        </td>
                        <td colspan="4" class="title-cantidad" style="margin: 1px 0 1px 0">
                            <p style="margin: 2px 0 2px 0">Precio Total </p>
                        </td>
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
                            <td colspan="4" class="detalle-cantidad">
                                <p>{{ $item->cantidad }} pz</p>
                            </td>
                            <td colspan="4" class="detalle-cantidad">
                                <p>$
                                    {{ number_format($item->precio_unitario * $taxFee, 2, '.', ',') }}</p>

                            </td>
                            <td colspan="4" class="detalle-cantidad">
                                <p>$
                                    {{ number_format($item->precio_total * $taxFee, 2, '.', ',') }}</p>
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
        <br>
        <br>
        <br>
        <div class="content">
            @if (strlen($quote->latestQuotesUpdate->quotesInformation->information) > 0)
                <p style="text-align: justify; font-size: 17px; line-height: 1.2rem"><span
                        style="font-weight: bold">Información Adicional:</span>
                    {{ $quote->latestQuotesUpdate->quotesInformation->information }}</p>
                <br>
            @endif
        </div>
        @if (!$quote_scales)
            @if ($quote->show_total)
                <table class="total content">
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
                        <td style="width: 150px">
                            <p><b>Subtotal: </b>$ {{ number_format($subtotal, 2, '.', ',') }}</p>
                            @if ($discount > 0)
                                <p><b>Descuento: </b>$ {{ number_format($discount, 2, '.', ',') }}</p>
                            @endif
                            @if (!$quote->iva_by_item)
                                <p><b>IVA: </b> $ {{ number_format($iva, 2, '.', ',') }}</p>
                            @endif
                            <p><b>Total: </b>$ {{ number_format($subtotal - $discount + $iva, 2, '.', ',') }}</p>
                        </td>
                    </tr>
                </table>
            @endif
        @endif
    </div>
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
            <li>Vigencia de la cotización {{ $quote->latestQuotesUpdate->quotesInformation->shelf_life ?: 5 }} días
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
    <div>
        <table class="content responsable" style="width: 105%">
            {{-- Modificacion en caso del user_id 52 (Ivonne Lopez) con otro gerente de la empresa PROMO LIFE --}}
            <tr>
                <td><img src="quotesheet/bh/icon-email.png"alt="">
                    {{ $user->id == 52 || $user->id == 62 ? 'Ricardo Zamora Rodriguez' : $user->companySession->manager }}
                    <b>GERENTE COMERCIAL</b>
                </td>
                <td><img src="quotesheet/bh/icon-email.png"alt="">
                    {{ $user->name }} <b>KAM</b></td>
            </tr>
            <tr>
                <td><img src="quotesheet/bh/icon-email.png"alt="">
                    {{ $user->id == 52 || $user->id == 62 ? 'ricardo.zamora@promolife.com.mx' : $user->companySession->email }}
                </td>
                <td><img src="quotesheet/bh/icon-email.png" alt="">
                    {{ $user->email }} </td>
            </tr>
            <tr>
                <td>
                    <img src="quotesheet/bh/icon-whatsapp.png" alt="">
                    {{ $user->id == 52 || $user->id == 62 ? '55 1963 4472' : $user->companySession->phone }}
                </td>
                <td><img src="quotesheet/bh/icon-whatsapp.png" alt=""> {{ $user->phone }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
