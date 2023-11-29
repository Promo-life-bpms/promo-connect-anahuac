<?php

namespace App\Models;

use App\Models\Catalogo\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muestra extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'address',
        'phone',
        'name',
        'product_id',
        'status',
        'current_quote_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function quote()
    {
        return $this->belongsTo(CurrentQuoteDetails::class, 'current_quote_id');
    }
}
