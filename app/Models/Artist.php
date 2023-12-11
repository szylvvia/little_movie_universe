<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'surname',
        'birth_date',
        'death_date',
        'description',
        'user_id',
        'status',
        'gender',
        'profession',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsToMany(Movie::class, 'movie_has_actor', 'movie_id', 'artist_id');
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}
