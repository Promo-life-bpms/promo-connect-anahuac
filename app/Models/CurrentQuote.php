<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentQuote extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'discount',
        'type',
        'value',
    ];

    public function currentQuoteDetails()
    {
        return $this->hasMany(CurrentQuoteDetails::class, 'current_quote_id');
    }
}
