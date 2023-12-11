<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'user_id'
    ];

    public function question()
    {
        return $this->hasMany(Question::class);
    }

    public function answer()
    {
        return $this->hasMany(Answer::class);
    }

}
