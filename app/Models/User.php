<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        "visible",
        "last_login",
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function currentQuote()
    {
        return $this->hasOne(CurrentQuote::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function sampleRequest()
    {
        return $this->hasMany(Muestra::class);
    }

    public function message()
    {
        return $this->hasMany(MessageSoporte::class, 'emisor_id', 'id');
    }
    public function commentsSupport()
    {
        return $this->hasMany(CommentsSupport::class);
    }
    public function muestras()
    {
        return $this->hasMany(Muestra::class, 'user_id', 'id');
    }
    public function direcciones()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(CommentsSupport::class, 'receiver_id', 'id');
    }

    public function punchoutSession()
    {
        return $this->hasOne(PunchoutSession::class);
    }
}
