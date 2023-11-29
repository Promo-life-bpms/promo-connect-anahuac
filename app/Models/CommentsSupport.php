<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentsSupport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message',
        'emisor_id',
        'seller_id',
        'received_id',
        'id_proceso_compra',
        'type_proceso_compra'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
