<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

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
