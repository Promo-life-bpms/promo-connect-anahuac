@component('mail::message')

# Cotizacion 

---

[Promo life S. de R.L. de C.V.](https://www.promolife.mx/)
San Andrés Atoto 155A Naucalpan de Juárez, Méx. C.P. 53550  
Tel. +52(55) 6269 0017 

Fecha: **{{ $date }}**

---

@foreach($quotes as $quote)

---

    @php
        try {
            if ($quote->logo != null) {
                $logo = public_path('/storage/logos/' . $quote->logo);
                $image64 = base64_encode(file_get_contents($logo));
            } else {
                $logo = public_path('img/default.jpg');
                $image64 = base64_encode(file_get_contents($logo));
            }
        } catch (\Exception $e) {
            $logo = public_path('img/default.jpg');
            $image64 = base64_encode(file_get_contents($logo));
        }

        $quoteTechnique = \App\Models\QuoteTechniques::where('quotes_id',$quote->id)->get()->last();

        $product = \App\Models\QuoteProducts::where('id', $quote->id)->get()->last();
        $productData = json_decode($product->product);

        $productName = isset($productData->name) ? $productData->name : 'Nombre no disponible';
        
            
    @endphp

#Cotizacion: **SQ-{{ $quote->id }}**

![Imagen de Referencia](data:image/png;base64,{{$image64}})

## Descripción
{{ $productName }}

### Técnica de Personalización
| Descripción                      | {{ isset($quote->currentQuotesTechniques->technique) ? $quote->currentQuotesTechniques->technique : '' }} |
|----------------------------------|-------------------------------------------------------------------------------------------------------------------|
| Material                         | {{ isset($quoteTechnique->material) ? $quoteTechnique->material : '' }}                                           |
| Tamaño                           | {{ isset($quoteTechnique->size) ? $quoteTechnique->size : '' }}                                                   |

**Tiempo de Entrega:** 15 días hábiles

### Detalles del Producto
| Cantidad         | Precio Unitario  | Precio total      |
|------------------|------------------|-------------------|
| {{ $product->cantidad }} piezas | {{ $product->precio_unitario }} | {{ $product->precio_total }} |

---

@endforeach

---

Condiciones:
- Condiciones de pago acordadas en el contrato
- Precios unitarios mostrados antes de IVA
- Precios mostrados en pesos mexicanos (MXP)

@endcomponent