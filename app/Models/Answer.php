<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerFactory> */
    use HasFactory;

    protected $fillable = [
        'content', // Tambahkan 'content' di sini
        'question_id', // Tambahkan kolom lain jika ada
        'user_id',
        // ... kolom lain yang ingin diizinkan
    ];

    public function question()
{
    return $this->belongsTo(Question::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

}
