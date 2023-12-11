<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'question_id',
        'quiz_id',
        "stat"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

}
