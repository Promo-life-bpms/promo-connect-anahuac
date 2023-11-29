<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageSoporte extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'receiver_id',
        'emisor_id',
        'soporte_id',
        'client_id',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'emisor_id');
    }
}
