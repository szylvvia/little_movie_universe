<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\WithFaker;

class Question extends Model
{
    use HasFactory, WithFaker;

    protected $fillable = [
        'question',
        'image',
        'quiz_id',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
    public function answer()
    {
        return $this->hasMany(Answer::class);
    }
}
