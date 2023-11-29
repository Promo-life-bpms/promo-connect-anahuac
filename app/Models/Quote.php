<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'iva_by_item',
        'address_id',
        'show_total',
        'logo',
        "direccion",
        'status'
    ];

    public function quotesUpdate()
    {
        return $this->hasMany(QuoteUpdate::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function latestQuotesUpdate()
    {
        return $this->hasOne(QuoteUpdate::class)->latestOfMany();
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
