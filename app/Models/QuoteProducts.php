<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteProducts extends Model
{
    use HasFactory;
    protected $fillable = [
        'product',
        'technique',
        'prices_techniques',
        'color_logos',
        'costo_indirecto',
        'utilidad',
        'dias_entrega',
        'cantidad',
        'precio_unitario',
        'precio_total',
        'scales_info',
        'quote_by_scales'
    ];
}
