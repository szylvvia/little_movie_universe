<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function artists()
    {
        return $this->hasMany(Artist::class);
    }

    protected $fillable = [
        'name',
        'email',
        'surname',
        'birth_date',
        'password',
        'description',
        'image',
        'background',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function getImageAttribute()
    {
        if ($this->attributes['image']) {
            return 'data:image/jpeg;base64,' . base64_encode($this->attributes['image']);
        }
        return 'path/to/default/image.jpg';
    }
    public function rate()
    {
        return $this->hasMany(Rate::class);
    }

    public function quiz()
    {
        return $this->hasMany(Quiz::class);
    }
}
