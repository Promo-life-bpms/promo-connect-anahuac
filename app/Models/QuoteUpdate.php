<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'quote_information_id',
        'quote_discount_id',
        'type',
    ];

    public function quoteProducts()
    {
        return $this->belongsToMany(QuoteProducts::class, 'quote_update_product', 'quote_update_id', 'quote_product_id');
    }

    public function quotesInformation()
    {
        return $this->belongsTo(QuoteInformation::class, 'quote_information_id');
    }

    public function quoteDiscount()
    {
        return $this->belongsTo(QuoteDiscount::class, 'quote_discount_id');
    }
}
