<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'release_date',
        'description',
        'trailer_link',
        'soundtrack_link',
        'poster',
        'user_id',
        'status'];

    public function image()
    {
        return $this->hasMany(Image::class);
    }

    public function artist()
    {
        return $this->belongsToMany(Artist::class,'movie_has_artist', 'movie_id', 'artist_id');
    }

    public function rate()
    {
        return $this->hasMany(Rate::class);
    }

    public function collection()
    {
        return $this->hasMany(Collection::class);
    }
}


