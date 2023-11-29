<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = ['url_banner', 'user_id', 'visible'];

    // Obtener el usuario que creó el banner
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
